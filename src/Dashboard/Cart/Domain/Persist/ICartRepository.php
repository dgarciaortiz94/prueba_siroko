<?php

namespace App\Dashboard\Cart\Domain\Persist;

use App\Dashboard\Cart\Domain\Aggregate\Cart;
use Doctrine\Common\Collections\Collection;

interface ICartRepository
{
    public function save(Cart $cart): Cart;

    public function remove(Cart $cart): void;

    public function search(string $id): Cart;

    public function searchAvailableProductItem(string $productId): Collection;
}
