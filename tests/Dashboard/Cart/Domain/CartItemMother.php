<?php

namespace App\Tests\Dashboard\Cart\Domain;

use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItem;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemId;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemTid;

class CartItemMother extends CartItem
{
    public static function create(
        string $id = '018de2ed-11f2-7e39-bd5e-f9fcbf1cf2d6',
        string $tid = 'R6D8A7FS6G8F77FSD68GSD786FGDS768',
        bool $active = true,
        CartProductMother $product = null
    ): self {
        $self = new self();

        $self->id = new CartItemId($id);
        $self->tid = new CartItemTid($tid);
        $self->active = $active;
        $self->product = $product ?? CartProductMother::create();

        return $self;
    }
}
