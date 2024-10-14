<?php

namespace Njbm\ShoppingCart;

use Illuminate\Support\Facades\Session;

class ShoppingCart
{
    protected $sessionKey = 'shopping_cart';

    public function __construct()
    {
        // Initialize session if not already set
        if (!Session::has($this->sessionKey)) {
            Session::put($this->sessionKey, []);
        }
    }

    /**
     * Add an item to the cart.
     * 
     * @param mixed $item
     * @param int $quantity
     */
    public function addItem($item, int $quantity)
    {
        $cart = Session::get($this->sessionKey);
        $cart[] = [
            'item' => $item,
            'quantity' => $quantity,
        ];
        Session::put($this->sessionKey, $cart);
    }

    /**
     * Remove an item from the cart.
     * 
     * @param mixed $item
     */
    public function removeItem($item)
    {
        $cart = Session::get($this->sessionKey);

        foreach ($cart as $key => $cartItem) {
            if ($cartItem['item'] === $item) {
                unset($cart[$key]);
                break;
            }
        }

        // Reindex array and update the session
        Session::put($this->sessionKey, array_values($cart));
    }

    /**
     * Get all items in the cart.
     * 
     * @return array
     */
    public function getItems(): array
    {
        return Session::get($this->sessionKey, []);
    }

    /**
     * Get total item count in the cart.
     * 
     * @return int
     */
    public function getTotalItems(): int
    {
        return count(Session::get($this->sessionKey, []));
    }

    /**
     * Clear the cart.
     */
    public function clear()
    {
        Session::forget($this->sessionKey);
    }
}
