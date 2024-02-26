<?php

namespace App\Dashboard\Cart\Domain\Persist;

use App\Dashboard\Cart\Domain\Aggregate\Cart;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartItemProduct;

interface ICartRepository
{
    public function save(Cart $cart): Cart;

    public function remove(Cart $cart): void;

    public function search(string $id): Cart;

    public function searchProduct(string $id): CartItemProduct;
}
