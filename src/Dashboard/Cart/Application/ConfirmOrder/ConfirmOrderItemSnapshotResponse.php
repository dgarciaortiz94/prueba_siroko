<?php

namespace App\Dashboard\Cart\Application\ConfirmOrder;

class ConfirmOrderItemSnapshotResponse
{
    public function __construct(
        private string $id,
        private string $itemId,
        private float $price
    ) {
    }

    /**
     * Get the value of id.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the value of itemId.
     */
    public function getItemId(): string
    {
        return $this->itemId;
    }

    /**
     * Get the value of price.
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}
