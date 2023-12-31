<?php

namespace App\Providers;

use App\Repositories\Implementations\EloquentBannerRepository;
use App\Repositories\Implementations\EloquentCartRepository;
use App\Repositories\Implementations\EloquentCategoryRepository;
use App\Repositories\Implementations\EloquentColorRepository;
use App\Repositories\Implementations\EloquentImageRepository;
use App\Repositories\Implementations\EloquentOrderItemRepository;
use App\Repositories\Implementations\EloquentOrderRepository;
use App\Repositories\Implementations\EloquentPaymentRepository;
use App\Repositories\Implementations\EloquentProductRepository;
use App\Repositories\Implementations\EloquentProductVariantRepository;
use App\Repositories\Implementations\EloquentSaleRepository;
use App\Repositories\Implementations\EloquentSoldRepository;
use App\Repositories\Implementations\EloquentUserLoginRepository;
use App\Repositories\Implementations\EloquentUserRepository;
use App\Repositories\Interfaces\BannerRepository;
use App\Repositories\Interfaces\CartRepository;
use App\Repositories\Interfaces\CategoryRepository;
use App\Repositories\Interfaces\ColorRepository;
use App\Repositories\Interfaces\ImageRepository;
use App\Repositories\Interfaces\OrderItemRepository;
use App\Repositories\Interfaces\OrderRepository;
use App\Repositories\Interfaces\PaymentRepository;
use App\Repositories\Interfaces\ProductRepository;
use App\Repositories\Interfaces\ProductVariantRepository;
use App\Repositories\Interfaces\SaleRepository;
use App\Repositories\Interfaces\SoldRepository;
use App\Repositories\Interfaces\UserLoginRepository;
use App\Repositories\Interfaces\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(ProductRepository::class, EloquentProductRepository::class);
        $this->app->bind(CategoryRepository::class, EloquentCategoryRepository::class);
        $this->app->bind(ColorRepository::class, EloquentColorRepository::class);
        $this->app->bind(ImageRepository::class, EloquentImageRepository::class);
        $this->app->bind(ProductVariantRepository::class, EloquentProductVariantRepository::class);
        $this->app->bind(BannerRepository::class, EloquentBannerRepository::class);
        $this->app->bind(CartRepository::class, EloquentCartRepository::class);
        $this->app->bind(OrderRepository::class, EloquentOrderRepository::class);
        $this->app->bind(OrderItemRepository::class, EloquentOrderItemRepository::class);
        $this->app->bind(PaymentRepository::class, EloquentPaymentRepository::class);
        $this->app->bind(SoldRepository::class, EloquentSoldRepository::class);
        $this->app->bind(SaleRepository::class, EloquentSaleRepository::class);
        $this->app->bind(UserLoginRepository::class, EloquentUserLoginRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
