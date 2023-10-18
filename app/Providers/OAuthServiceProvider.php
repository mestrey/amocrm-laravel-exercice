<?php

namespace App\Providers;

use AmoCRM\OAuth\OAuthConfigInterface;
use AmoCRM\OAuth\OAuthServiceInterface;
use App\OAuth\OAuthConfig;
use App\OAuth\OAuthService;
use Illuminate\Support\ServiceProvider;

class OAuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(OAuthConfigInterface::class, function () {
            return new OAuthConfig(
                config('amocrm.api.clientId'),
                config('amocrm.api.clientSecret'),
                config('amocrm.api.clientRedirectUri')
            );
        });

        $this->app->singleton(OAuthServiceInterface::class, OAuthService::class);
    }
}
