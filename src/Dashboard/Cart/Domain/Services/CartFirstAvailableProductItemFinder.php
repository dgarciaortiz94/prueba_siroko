<?php

namespace App\Dashboard\Cart\Domain\Services;

use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItem;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartItemProductId;
use App\Dashboard\Cart\Domain\Persist\ICartRepository;
use App\Dashboard\Cart\Domain\Services\Exception\NoAvailableItemsException;
use Doctrine\Common\Collections\ArrayCollection;

class CartFirstAvailableProductItemFinder
{
    public function __construct(private ICartRepository $repository)
    {
    }

    public function __invoke(CartItemProductId $productId): CartItem
    {
        $items = $this->repository->searchAvailableProductItem($productId->value());

        return $this->firstAvailableItem($items);
    }

    private function firstAvailableItem(ArrayCollection $items): CartItem
    {
        if ($items->isEmpty()) {
            throw new NoAvailableItemsException();
        }

        return $items->first();
    }
}
