<?php

namespace App\Dashboard\Cart\Domain\Persist;

use App\Dashboard\Cart\Domain\Aggregate\Cart;

interface ICartRepository
{
    public function save(): Cart;

    public function remove(Cart $cart): void;

    public function search(string $id): Cart;

    public function searchByCriteria(array $criteria): array;
}
