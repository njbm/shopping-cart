<?php

namespace Njbm\ShoppingCart;

use Illuminate\Support\ServiceProvider;

class ShoppingCartServiceProvider extends ServiceProvider
{
    /**
     * Register the service in the container.
     */
    public function register()
    {
        $this->app->singleton('shopping-cart', function ($app) {
            return new ShoppingCart();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        
    }
}
