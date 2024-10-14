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
     * @param int $productId
     * @param int|null $userId
     * @param int $quantity
     * @param string|null $type
     * @param float $itemPrice
     * @param float $supportPrice
     * @param float $price
     * @param array $dynamicFields // Additional dynamic fields
     */
    public function addItem(
      int $productId,
      ?int $userId,
      int $quantity,
      ?string $type,
      float $itemPrice,
      float $supportPrice,
      float $price,
      array $dynamicFields = []
  ) {
      // Retrieve the current cart from the session
      $cart = Session::get($this->sessionKey, []);

      $sessionId = session()->getId();

      $cartItem = [
          'product_id' => $productId,
          'user_id' => $userId,
          'session_id' => $sessionId,
          'quantity' => $quantity,
          'type' => $type,
          'item_price' => $itemPrice,
          'price' => $price,
      ];

      // Merge dynamic fields into the cart item
      $cartItem = array_merge($cartItem, $dynamicFields);

      // Add the new item to the cart
      $cart[] = $cartItem;

      // Save the updated cart back to the session
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
