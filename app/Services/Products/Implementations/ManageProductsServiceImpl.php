<?php

namespace App\Services\Products\Implementations;

use App\DTOs\Products\CreateProductDto;
use App\DTOs\Products\UpdateProductDto;
use App\Exceptions\Products\ProductCanNotDeleteException;
use App\Exceptions\UniqueFieldException;
use App\Models\Product;
use App\Repositories\Interfaces\ImageRepository;
use App\Repositories\Interfaces\ProductRepository;
use App\Repositories\Interfaces\ProductVariantRepository;
use App\Services\Products\Interfaces\ManageProductsService;
use App\Services\Upload\Interfaces\UploadService;
use App\Utils\UploadFolder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ManageProductsServiceImpl implements ManageProductsService
{
    public function __construct(
        private ProductRepository $productRepository,
        private ProductVariantRepository $productVariantRepository,
        private ImageRepository $imageRepository,
        private UploadService $uploadService
    ) {}

    public function createProduct(CreateProductDto $createProductDto): Product {
        $sku = $this->generateSKUs();

        DB::beginTransaction();
        try {
            $product = $this->productRepository->create([
                'name' => $createProductDto->name,
                'slug' => Str::slug($createProductDto->name),
                'code' => $sku,
                'category_id' => $createProductDto->categoryId,
                'description' => $createProductDto->description,
                'material' => $createProductDto->material,
                'price' => $createProductDto->price,
                'selling_price' => $createProductDto->sellingPrice,
                'discount' => $createProductDto->discount,
                'thumbnail_url' => ''
            ]);

            $totalQuantity = 0;
            $createProductDto->variants ??= [];
            foreach ($createProductDto->variants as $variant) {
                $this->productVariantRepository->create([
                    'product_id' => $product->id,
                    'color_id' => $variant['colorId'],
                    'size' => $variant['size'] ?? "NONE",
                    'quantity' => $variant['quantity'],
                ]);

                $totalQuantity += $variant['quantity'];
            }

            // Upload images
            $createProductDto->colorImages ??= [];
            foreach ($createProductDto->colorImages as $colorImage) {
                $uploadResult = $this->uploadService->uploadFile($colorImage['image'], [
                    'folder' => UploadFolder::PRODUCT_IMAGES . '/' . $product->id . '/color-' . $colorImage['colorId']
                ]);

                $this->imageRepository->create([
                    'product_id' => $product->id,
                    'color_id' => $colorImage['colorId'],
                    'image_url' => $uploadResult['path'],
                ]);
            }

            $thumbnailUploadedResult = $this->uploadService->uploadFile($createProductDto->thumbnail, [
                'folder' => UploadFolder::PRODUCT_IMAGES . '/' . $product->id,
                'fileName' => 'thumbnail.jpg'
            ]);
    
            if ($createProductDto->sizeGuild) {
                $sizeGuildUploadedResult = $this->uploadService->uploadFile($createProductDto->sizeGuild, [
                    'folder' => UploadFolder::PRODUCT_IMAGES . '/' . $product->id,
                    'fileName' => 'size_guild.jpg'
                ]);
            }

            $this->productRepository->update($product->id, [
                'quantity' => $totalQuantity,
                'thumbnail_url' => $thumbnailUploadedResult['path'],
                'size_guild_url' => isset($sizeGuildUploadedResult) ? $sizeGuildUploadedResult['path'] : null,
            ]);

            DB::commit();
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();
            // If have any error, delete files create previout
            if (isset($thumbnailUploadedResult)) {
                $this->uploadService->deleteFile($thumbnailUploadedResult['path']);
            }
            
            if (isset($sizeGuildUploadedResult)) {
                $this->uploadService->deleteFile($sizeGuildUploadedResult['path']);
            }

            throw new UniqueFieldException();
        }

        return $product;
    }

    public function updateProduct($id, UpdateProductDto $updateProductDto): Product {
        $data = [
            'name' => $updateProductDto->name,
            'slug' => Str::slug($updateProductDto->name),
            'category_id' => $updateProductDto->categoryId,
            'description' => $updateProductDto->description,
            'material' => $updateProductDto->material,
            'price' => $updateProductDto->price,
            'selling_price' => $updateProductDto->sellingPrice,
            'discount' => $updateProductDto->discount,
        ];

        if ($updateProductDto->thumbnail) {
            $thumbnailUploadedResult = $this->uploadService->uploadFile($updateProductDto->thumbnail, [
                'folder' => UploadFolder::PRODUCT_IMAGES . '/' . $id,
                'fileName' => 'thumbnail.jpg'
            ]);

            $data['thumbnail_url'] = $thumbnailUploadedResult['path'];
        }

        if ($updateProductDto->sizeGuild) {
            $sizeGuildUploadedResult = $this->uploadService->uploadFile($updateProductDto->sizeGuild, [
                'folder' => UploadFolder::PRODUCT_IMAGES . '/' . $id,
                'fileName' => 'size_guild.jpg'
            ]);
        
            $data['size_guild_url'] = $sizeGuildUploadedResult['path'];
        }

        DB::beginTransaction();
        try {
            $product = $this->productRepository->update($id, $data);

            $totalQuantity = 0;
            $updateProductDto->variants ??= [];
            foreach ($updateProductDto->variants as $variant) {
                $this->productVariantRepository->create([
                    'product_id' => $product->id,
                    'color_id' => $variant['colorId'],
                    'size' => $variant['size'] ?? "NONE",
                    'quantity' => $variant['quantity'],
                ]);

                $totalQuantity += $variant['quantity'];
            }

            // Upload color images
            $updateProductDto->colorImages ??= [];
            foreach ($updateProductDto->colorImages as $colorImage) {
                $uploadResult = $this->uploadService->uploadFile($colorImage['image'], [
                    'folder' => UploadFolder::PRODUCT_IMAGES . '/' . $product->id . '/color-' . $colorImage['colorId']
                ]);

                $this->imageRepository->create([
                    'product_id' => $product->id,
                    'color_id' => $colorImage['colorId'],
                    'image_url' => $uploadResult['path'],
                ]);
            }

            $this->productRepository->update($product->id, [
                'quantity' => $totalQuantity + $product->quantity
            ]);

            DB::commit();
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollBack();

            throw new UniqueFieldException();
        }

        return $product;
    }

    public function deleteProduct($id): bool {
        $haveOrder = $this->productRepository->checkHaveOrder($id);

        if ($haveOrder) throw new ProductCanNotDeleteException("Can not delete product");

        return $this->productRepository->delete($id);
    }

    private function generateSKUs() : string {
        $timestamp = now()->timestamp;
        $randomString = Str::random(4);

        $sku = 'CTL' . $timestamp . $randomString;

        return $sku;
    }
}
