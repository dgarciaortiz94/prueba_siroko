<?php

namespace App\Dashboard\Cart\Application\AddProductToCart\Services;

use App\Dashboard\Cart\Domain\Aggregate\Cart;
use App\Dashboard\Cart\Domain\Persist\ICartRepository;

class CartProductAggregator
{
    public function __construct(
        private ICartRepository $repository
    ) {
    }

    public function __invoke(Cart $cart): Cart
    {
        return $this->repository->save($cart);
    }
}