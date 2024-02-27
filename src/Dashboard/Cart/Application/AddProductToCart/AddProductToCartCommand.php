<?php

namespace App\Dashboard\Cart\Application\AddProductToCart;

use App\Shared\Domain\Bus\Command\ICommand;

class AddProductToCartCommand implements ICommand
{
    public function __construct(
        private string $cartId,
        private string $productId
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
    public function productId(): string
    {
        return $this->productId;
    }
}
