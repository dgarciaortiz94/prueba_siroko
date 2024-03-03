<?php

namespace App\Dashboard\Cart\Domain\Services;

use App\Dashboard\Cart\Domain\Aggregate\Cart;
use App\Dashboard\Cart\Domain\Persist\ICartRepository;

class CartPersister
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
