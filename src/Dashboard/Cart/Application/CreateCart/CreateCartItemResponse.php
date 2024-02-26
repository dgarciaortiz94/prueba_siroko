<?php

namespace App\Dashboard\Cart\Application\CreateCart;

class CreateCartItemResponse
{
    public function __construct(
        private string $id,
        private string $productTracingCode,
        private string $modelName,
        private string $productVariant,
        private string $modelDescription,
        private string $productDescription,
        private string $itemTid
    ) {
    }

    /**
     * Get the value of id.
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * Get the value of productTracingCode.
     */
    public function productTracingCode(): string
    {
        return $this->productTracingCode;
    }

    /**
     * Get the value of modelName.
     */
    public function modelName(): string
    {
        return $this->modelName;
    }

    /**
     * Get the value of productVariant.
     */
    public function productVariant(): string
    {
        return $this->productVariant;
    }

    /**
     * Get the value of modelDescription.
     */
    public function modelDescription(): string
    {
        return $this->modelDescription;
    }

    /**
     * Get the value of productDescription.
     */
    public function productDescription(): string
    {
        return $this->productDescription;
    }

    /**
     * Get the value of itemTid.
     */
    public function itemTid(): string
    {
        return $this->itemTid;
    }
}
