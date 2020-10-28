<?php

namespace App\Providers;

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
