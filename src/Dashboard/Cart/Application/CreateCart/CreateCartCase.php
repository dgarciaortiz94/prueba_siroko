<?php

namespace App\Dashboard\Cart\Application\CreateCart;

use App\Dashboard\Cart\Application\Shared\CartItemResponse;
use App\Dashboard\Cart\Application\Shared\CartResponse;
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

    public function __invoke(Cart $cart): CartResponse
    {
        $cart = $this->cartCreator->__invoke($cart);

        // $this->domainEventBus->publish(...$cart->pullDomainEvents());

        $itemResponses = [];
        $totalPrice = null;

        foreach ($cart->items() as $item) {
            $itemResponses[] = new CartItemResponse(
                $item->id(),
                $item->productTracingCode(),
                $item->modelName(),
                $item->productVariant(),
                $item->modelDescription(),
                $item->productDescription(),
                $item->tid(),
                $item->price()
            );

            $totalPrice += $item->price();
        }

        return new CartResponse(
            $cart->id(),
            $totalPrice,
            ...$itemResponses
        );
    }
}
