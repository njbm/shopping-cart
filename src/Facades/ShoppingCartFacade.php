<?php

namespace Njbm\ShoppingCart\Facades;

use Illuminate\Support\Facades\Facade;

class ShoppingCartFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'shopping-cart';
    }
}
