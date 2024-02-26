<?php

namespace App\Tests\Dashboard\Cart\Domain;

use App\Dashboard\Cart\Domain\Aggregate\Cart;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItem;
use App\Dashboard\Cart\Domain\Aggregate\CartUser\CartUser;

class CartMother
{
    private Cart $cart;

    private function __construct(
        CartItem $item,
        CartUser $user = null
    ) {
        $this->cart = Cart::create(
            $item,
            $user
        );
    }

    public static function create(
        CartItem $item,
        CartUser $user = null
    ): Cart {
        $self = new self(
            $item,
            $user
        );

        return $self->cart;
    }
}
