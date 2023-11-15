<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\Products\CreateProductDto;
use App\DTOs\Products\ProductParamsDto;
use App\DTOs\Products\UpdateProductDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Services\Categories\Interfaces\GetCategoriesService;
use App\Services\Colors\Interfaces\GetColorsService;
use Illuminate\Http\Request;
use App\Services\Products\Interfaces\GetProductsService;
use App\Services\Products\Interfaces\ManageProductsService;

class ProductsController extends Controller
{
    public function __construct(
        private GetCategoriesService $getCategoriesService,
        private GetColorsService $getColorsService,
        private GetProductsService $getProductsService,
        private ManageProductsService $manageProductsService
    ) {
        $this->middleware('role:ADMIN,null,null')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = ProductParamsDto::fromRequest($request);

        $products = $this->getProductsService->getProductsByParams($params);

        $this->appendPaginatorURL($products);

        return view("admin.products.index", compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // get categories and colors for product to select
        $categories = $this->getCategoriesService->getAllCategories();
        $colors = $this->getColorsService->getAllColors();

        return view("admin.products.create", compact('categories', 'colors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $request->validated();
        $createProductDto = CreateProductDto::fromRequest($request);

        $product = $this->manageProductsService->createProduct($createProductDto);

        return redirect()->route("admin.products.index")->with('success', $product->name.' created!');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->getProductsService->getProductById($id, ['images', 'productVariants', 'category']);

        return view("admin.products.show", ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->getProductsService->getProductById($id, ['images', 'productVariants', 'category']);
        
        // get categories and colors for product to select
        $categories = $this->getCategoriesService->getAllCategories();
        $colors = $this->getColorsService->getAllColors();

        return view("admin.products.edit", compact('product', 'categories', 'colors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $request->validated();
        $updateProductDto = UpdateProductDto::fromRequest($request);

        $product = $this->manageProductsService->updateProduct($id, $updateProductDto);

        return redirect()->route("admin.products.index")->with('success', $product->name.' updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->manageProductsService->deleteProduct($id);

        return redirect()->route("admin.products.index")->with("success", "Product deleted !");
    }
}
