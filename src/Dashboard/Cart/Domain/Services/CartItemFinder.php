<?php

namespace App\Dashboard\Cart\Domain\Services;

use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItem;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemId;
use App\Dashboard\Cart\Domain\Persist\ICartRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CartItemFinder
{
    public function __construct(private ICartRepository $repository)
    {
    }

    public function __invoke(CartItemId $id): CartItem
    {
        $item = $this->repository->searchItem($id->value());

        $this->checkItemExists($item);

        return $item;
    }

    private function checkItemExists(?CartItem $item): void
    {
        if (!$item) {
            throw new NotFoundHttpException('Item not found by this id');
        }
    }
}
