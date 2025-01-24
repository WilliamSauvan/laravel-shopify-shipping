<?php

namespace ShopifyShipping;

use Illuminate\Support\ServiceProvider;
use ShopifyShipping\Commands\ManageShippingCommand;
use ShopifyShipping\Services\ShopifyShippingService;

class ShopifyShippingServiceProvider extends ServiceProvider
{
    protected const string CONFIG_PATH = __DIR__ . '/../config/laravel-shopify-shipping.php';

    public function register()
    {
        $this->mergeConfigFrom(self::CONFIG_PATH, 'laravel-shopify-shipping');

        $this->app->singleton('ShopifyShippingService', function () {
            return new ShopifyShippingService();
        });
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        if ($this->app->runningInConsole()) {
            $this->registerPublishables();
            $this->registerCommands();
        }
    }

    protected function registerCommands(): void
    {
        $this->commands([
            ManageShippingCommand::class,
        ]);
    }

    protected function registerPublishables(): void
    {
        $this->publishes([
            self::CONFIG_PATH => config_path('laravel-shopify-shipping.php'),
        ], 'config');
    }
}
