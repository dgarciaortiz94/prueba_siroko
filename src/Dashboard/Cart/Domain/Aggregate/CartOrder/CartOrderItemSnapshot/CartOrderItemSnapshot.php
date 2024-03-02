<?php

namespace App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderItemSnapshot;

use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItem;

class CartOrderItemSnapshot
{
    private CartOrderItemSnapshotId $id;

    private CartItem $item;

    private CartOrderItemSnapshotPrice $price;

    private function __construct()
    {
        $this->id = new CartOrderItemSnapshotId();
    }

    public static function create(
        CartItem $item,
        CartOrderItemSnapshotPrice $price
    ): self {
        $self = new self();

        $self->item = $item;
        $self->price = $price;

        return $self;
    }

    /**
     * Get the value of id.
     */
    public function id(): string
    {
        return $this->id->value();
    }

    /**
     * Get the value of item id.
     */
    public function itemId(): string
    {
        return $this->item->id();
    }

    /**
     * Get the value of price.
     */
    public function price(): string
    {
        return $this->price->value();
    }
}
