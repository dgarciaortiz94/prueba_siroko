<?php

namespace App\Tests\Dashboard\Cart\Domain;

use App\Dashboard\Cart\Domain\Aggregate\Cart;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItem;
use App\Dashboard\User\Domain\Agregate\User;

class CartMother
{
    private Cart $cart;

    private function __construct(
        CartItem $item,
        User $user = null
    ) {
        $this->cart = Cart::create(
            $item,
            $user
        );
    }

    public static function create(
        CartItem $item,
        User $user = null
    ): Cart {
        $self = new self(
            $item,
            $user
        );

        return $self->cart;
    }
}
