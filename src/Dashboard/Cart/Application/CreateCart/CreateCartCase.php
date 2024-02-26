<?php

namespace App\Dashboard\Cart\Application\CreateCart;

use App\Dashboard\Cart\Domain\Aggregate\Cart;
use App\Dashboard\Cart\Domain\Services\CartCreator;
use App\Shared\Domain\Bus\DomainEvent\IDomainEventBus;

class CreateCartCase
{
    public function __construct(
        private CartCreator $cartCreator,
        private IDomainEventBus $domainEventBus
    ) {
    }

    public function __invoke(Cart $cart): CreateCartResponse
    {
        $cart = $this->cartCreator->__invoke($cart);

        // $this->domainEventBus->publish(...$cart->pullDomainEvents());

        $itemResponses = [];
        $totalPrice = null;

        foreach ($cart->items() as $item) {
            $itemResponses[] = new CreateCartItemResponse(
                $item->id(),
                $item->productTracingCode(),
                $item->modelName(),
                $item->productVariant(),
                $item->modelDescription(),
                $item->productDescription(),
                $item->tid()
            );

            $totalPrice += $item->price();
        }

        return new CreateCartResponse(
            $cart->id(),
            $totalPrice,
            ...$itemResponses
        );
    }
}
