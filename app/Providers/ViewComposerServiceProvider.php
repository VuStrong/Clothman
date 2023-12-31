<?php

namespace App\Providers;

use App\Http\ViewComposers\CategoryComposer;
use Illuminate\Support\Facades;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Facades\View::composer([
            'home',
            'product-detail',
            'products',
            'search',
            'cart',
            'account.infor',
            'account.password',
            'account.orders',
            'account.order-detail',
            'checkout.success',
            'checkout.cancel',
        ], CategoryComposer::class);
    }
}
