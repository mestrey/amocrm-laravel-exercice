<?php

namespace App\Providers;

use AmoCRM\Client\AmoCRMApiClientFactory;
use AmoCRM\OAuth\OAuthConfigInterface;
use AmoCRM\OAuth\OAuthServiceInterface;
use App\Services\AmoApiService;
use App\Services\AmoApiServiceInterface;
use Illuminate\Support\ServiceProvider;

class AmoApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AmoCRMApiClientFactory::class, function () {
            return new AmoCRMApiClientFactory(
                $this->app->make(OAuthConfigInterface::class),
                $this->app->make(OAuthServiceInterface::class)
            );
        });

        $this->app->singleton(AmoApiServiceInterface::class, AmoApiService::class);
    }
}
