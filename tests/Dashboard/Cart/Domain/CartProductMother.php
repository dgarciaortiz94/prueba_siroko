<?php

namespace App\Tests\Dashboard\Cart\Domain;

use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartItemProduct;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartItemProductDescription;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartItemProductId;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartItemProductPrice;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartItemProductTracingCode;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartItemProductVariant;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartProductModel\CartProductModel;

class CartProductMother extends CartItemProduct
{
    public static function create(
        string $id = '018de2e6-b19a-77d8-9192-acd29b71d0d6',
        int $tracingCode = 0000001,
        string $variant = 'S',
        string $description = 'Talla S',
        float $price = 79.95,
        CartProductModel $model = null
    ): self {
        $self = new self();

        $self->id = new CartItemProductId($id);
        $self->tracingCode = new CartItemProductTracingCode($tracingCode);
        $self->variant = new CartItemProductVariant($variant);
        $self->description = new CartItemProductDescription($description);
        $self->model = $model ?? CartModelMother::create();
        $self->price = new CartItemProductPrice($price);

        return $self;
    }
}
