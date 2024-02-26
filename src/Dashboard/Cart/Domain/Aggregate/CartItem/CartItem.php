<?php

namespace App\Dashboard\Cart\Domain\Aggregate\CartItem;

use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartItemProduct;

class CartItem
{
    protected CartItemId $id;

    protected CartItemTid $tid;

    protected CartItemProduct $product;

    protected bool $active;

    /**
     * Get the value of id.
     */
    public function id(): string
    {
        return $this->id->value();
    }

    /**
     * Get the value of tid.
     */
    public function tid(): string
    {
        return $this->tid->value();
    }

    /**
     * Get the value of active.
     */
    public function active(): bool
    {
        return $this->active;
    }

    /**
     * Get the value of product id.
     */
    public function productId(): string
    {
        return $this->product->id();
    }

    /**
     * Get the value of product tracing code.
     */
    public function productTracingCode(): int
    {
        return $this->product->tracingCode();
    }

    /**
     * Get the value of product variant.
     */
    public function productVariant(): string
    {
        return $this->product->variant();
    }

    /**
     * Get the value of product description.
     */
    public function productDescription(): string
    {
        return $this->product->description();
    }

    /**
     * Get the value of model name.
     */
    public function modelName(): string
    {
        return $this->product->modelName();
    }

    /**
     * Get the value of model description.
     */
    public function modelDescription(): string
    {
        return $this->product->modelDescription();
    }

    /**
     * Get the value of price.
     */
    public function price(): float
    {
        return $this->product->price();
    }
}
