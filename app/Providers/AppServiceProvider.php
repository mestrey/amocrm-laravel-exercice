<?php

namespace App\Providers;

use App\Repositories\AccessTokenRepository;
use App\Repositories\AccessTokenRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AccessTokenRepositoryInterface::class, AccessTokenRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
