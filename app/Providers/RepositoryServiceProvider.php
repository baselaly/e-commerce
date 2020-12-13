<?php

namespace App\Providers;

use App\Repositories\Cart\CartInterfaceRepository;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Checkout\CheckoutInterfaceRepository;
use App\Repositories\Checkout\CheckoutRepository;
use App\Repositories\Like\LikeInterfaceRepository;
use App\Repositories\Like\LikeRepository;
use App\Repositories\Product\ProductInterfaceRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\ProductImage\ProductImageInterfaceRepository;
use App\Repositories\ProductImage\ProductImageRepository;
use App\Repositories\Store\StoreInterfaceRepository;
use App\Repositories\Store\StoreRepository;
use App\Repositories\User\UserInterfaceRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserInterfaceRepository::class, UserRepository::class);
        $this->app->bind(StoreInterfaceRepository::class, StoreRepository::class);
        $this->app->bind(ProductInterfaceRepository::class, ProductRepository::class);
        $this->app->bind(ProductImageInterfaceRepository::class, ProductImageRepository::class);
        $this->app->bind(CartInterfaceRepository::class, CartRepository::class);
        $this->app->bind(CheckoutInterfaceRepository::class, CheckoutRepository::class);
        $this->app->bind(LikeInterfaceRepository::class, LikeRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
