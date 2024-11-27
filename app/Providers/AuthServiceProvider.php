<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Auth\JsonUserProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        Auth::provider('json', function ($app, array $config) {
            return new JsonUserProvider(
                $app['hash'],
                $config['model'],
                $config['storage_path']
            );
        });

    }
}
