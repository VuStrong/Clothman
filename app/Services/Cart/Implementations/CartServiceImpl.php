<?php

namespace App\Services\Cart\Implementations;

use App\DTOs\Cart\AddToCartDto;
use App\Repositories\Interfaces\CartRepository;
use App\Repositories\Interfaces\ProductVariantRepository;
use App\Services\Cart\Interfaces\CartService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CartServiceImpl implements CartService
{
    public function __construct(
        private CartRepository $cartRepository,
        private ProductVariantRepository $productVariantRepository,
    ) {}

    public function getCarts(): Collection {
        if (Auth::check()) {
            return $this->cartRepository->getAllByUserId(Auth::id());
        } else {
            return collect([]);
        }
    }

    public function addToCart(AddToCartDto $data): bool {
        $productVariant = $this->productVariantRepository->findByDetail(
            $data->productId,
            $data->colorId,
            $data->size,
        );

        if (!$productVariant) {
            throw new ModelNotFoundException();
        }

        if (Auth::check()) {
            $userId = Auth::id();
            $cart = $this->cartRepository->findByDetail($data->productId, $productVariant->id, $userId);

            if ($cart) {
                $this->cartRepository->update($cart->id, [
                    'quantity' => $cart->quantity + $data->quantity,
                ]);
            } else {
                $this->cartRepository->create([
                    'product_id' => $data->productId,
                    'product_variant_id' => $productVariant->id,
                    'user_id' => $userId,
                    'quantity' => $data->quantity,
                ]);
            }
        } else {
            
        }

        return true;
    }
}