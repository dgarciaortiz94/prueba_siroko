<?php

namespace App\Tests\Dashboard\Cart\Domain;

use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartProductModel\CartProductModel;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartProductModel\CartProductModelDescription;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartProductModel\CartProductModelId;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartProductModel\CartProductModelName;

class CartModelMother extends CartProductModel
{
    public static function create(
        $id = '018de2e2-f5ae-7d29-bb08-8e25d5558e02',
        $name = 'W1 SKYWALK',
        $description = 'Chaqueta para snowboard/esquí hombre'
    ): self {
        $self = new self();

        $self->id = new CartProductModelId($id);
        $self->name = new CartProductModelName($name);
        $self->description = new CartProductModelDescription($description);

        return $self;
    }
}
