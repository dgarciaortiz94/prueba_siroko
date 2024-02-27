<?php

namespace App\Dashboard\Cart\Domain\Services;

use App\Dashboard\Cart\Domain\Aggregate\Cart;
use App\Dashboard\Cart\Domain\Aggregate\CartId;
use App\Dashboard\Cart\Domain\Persist\ICartRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CartFinder
{
    public function __construct(private ICartRepository $repository)
    {
    }

    public function __invoke(CartId $id): Cart
    {
        $cart = $this->repository->search($id->value());

        $this->checkItemExists($cart);

        return $cart;
    }

    private function checkItemExists(?Cart $cart): void
    {
        if (!$cart) {
            throw new NotFoundHttpException('Cart not found by this id');
        }
    }
}
