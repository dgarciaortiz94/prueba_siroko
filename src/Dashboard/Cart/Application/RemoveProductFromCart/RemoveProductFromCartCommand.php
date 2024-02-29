<?php

namespace App\Dashboard\Cart\Application\RemoveProductFromCart;

class RemoveProductFromCartCommand
{
    public function __construct(
        private string $cartId,
        private string $itemId
    ) {
    }

    /**
     * Get the value of cartId.
     */
    public function cartId(): string
    {
        return $this->cartId;
    }

    /**
     * Get the value of productId.
     */
    public function itemId(): string
    {
        return $this->itemId;
    }
}
