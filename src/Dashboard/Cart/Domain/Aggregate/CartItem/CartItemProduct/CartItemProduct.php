<?php

namespace App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct;

use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartProductModel\CartProductModel;

class CartItemProduct
{
    private CartItemProductId $id;

    private CartItemProductTracingCode $tracingCode;

    private CartItemProductVariant $variant;

    private CartItemProductDescription $description;

    private CartProductModel $model;

    private CartItemProductPrice $price;

    /**
     * Get the value of id.
     */
    public function getId(): CartItemProductId
    {
        return $this->id;
    }

    /**
     * Get the value of tracingCode.
     */
    public function getTracingCode(): CartItemProductTracingCode
    {
        return $this->tracingCode;
    }

    /**
     * Get the value of variant.
     */
    public function getVariant(): CartItemProductVariant
    {
        return $this->variant;
    }

    /**
     * Get the value of description.
     */
    public function getDescription(): CartItemProductDescription
    {
        return $this->description;
    }

    /**
     * Get the value of model.
     */
    public function getModel(): CartProductModel
    {
        return $this->model;
    }

    /**
     * Get the value of price.
     */
    public function getPrice(): CartItemProductPrice
    {
        return $this->price;
    }
}
