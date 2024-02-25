<?php

namespace App\Dashboard\Cart\Domain\Aggregate\CartItem;

use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartItemProduct;

class CartItem
{
    private CartItemId $id;

    private string $tid;

    private CartItemProduct $product;

    private bool $active;

    /**
     * Get the value of id.
     */
    public function getId(): string
    {
        return $this->id->value();
    }

    /**
     * Get the value of tid.
     */
    public function getTid(): string
    {
        return $this->tid;
    }

    /**
     * Get the value of active.
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * Get the value of product.
     */
    public function getProduct(): CartItemProduct
    {
        return $this->product;
    }
}
