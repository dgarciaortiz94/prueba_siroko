<?php

namespace App\Dashboard\Cart\Application\Shared;

class CartItemResponse
{
    public function __construct(
        private string $id,
        private string $productTracingCode,
        private string $modelName,
        private string $productVariant,
        private string $modelDescription,
        private string $productDescription,
        private string $itemTid,
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
     * Get the value of productTracingCode.
     */
    public function getProductTracingCode(): string
    {
        return $this->productTracingCode;
    }

    /**
     * Get the value of modelName.
     */
    public function getModelName(): string
    {
        return $this->modelName;
    }

    /**
     * Get the value of productVariant.
     */
    public function getProductVariant(): string
    {
        return $this->productVariant;
    }

    /**
     * Get the value of modelDescription.
     */
    public function getModelDescription(): string
    {
        return $this->modelDescription;
    }

    /**
     * Get the value of productDescription.
     */
    public function getProductDescription(): string
    {
        return $this->productDescription;
    }

    /**
     * Get the value of itemTid.
     */
    public function getItemTid(): string
    {
        return $this->itemTid;
    }

    /**
     * Get the value of price.
     */
    public function getPrice(): float
    {
        return $this->price;
    }
}
