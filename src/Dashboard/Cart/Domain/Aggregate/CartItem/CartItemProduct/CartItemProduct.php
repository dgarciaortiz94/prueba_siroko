<?php

namespace App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct;

use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartProductModel\CartProductModel;

class CartItemProduct
{
    protected CartItemProductId $id;

    protected CartItemProductTracingCode $tracingCode;

    protected CartItemProductVariant $variant;

    protected CartItemProductDescription $description;

    protected CartProductModel $model;

    protected CartItemProductPrice $price;

    /**
     * Get the value of id.
     */
    public function id(): string
    {
        return $this->id->value();
    }

    /**
     * Get the value of tracingCode.
     */
    public function tracingCode(): int
    {
        return $this->tracingCode->value();
    }

    /**
     * Get the value of variant.
     */
    public function variant(): string
    {
        return $this->variant->value();
    }

    /**
     * Get the value of description.
     */
    public function description(): string
    {
        return $this->description->value();
    }

    /**
     * Get the value of model id.
     */
    public function modelId(): string
    {
        return $this->model->id();
    }

    /**
     * Get the value of model name.
     */
    public function modelName(): string
    {
        return $this->model->name();
    }

    /**
     * Get the value of model description.
     */
    public function modelDescription(): string
    {
        return $this->model->description();
    }

    /**
     * Get the value of price.
     */
    public function price(): float
    {
        return $this->price->value();
    }
}
