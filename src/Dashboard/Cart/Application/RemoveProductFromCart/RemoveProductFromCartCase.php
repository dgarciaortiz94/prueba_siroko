<?php

namespace App\Dashboard\Cart\Application\RemoveProductFromCart;

use App\Dashboard\Cart\Application\Shared\CartItemResponse;
use App\Dashboard\Cart\Application\Shared\CartResponse;
use App\Dashboard\Cart\Domain\Aggregate\CartId;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemId;
use App\Dashboard\Cart\Domain\Services\CartFinder;
use App\Dashboard\Cart\Domain\Services\CartItemFinder;
use App\Dashboard\Cart\Domain\Services\CartPersister;
use App\Shared\Domain\Bus\DomainEvent\IDomainEventBus;

class RemoveProductFromCartCase
{
    public function __construct(
        private CartFinder $cartFinder,
        private CartItemFinder $itemFinder,
        private CartPersister $cartPersister,
        private IDomainEventBus $domainEventBus
    ) {
    }

    public function __invoke(CartId $cartId, CartItemId $itemId): CartResponse
    {
        $cart = $this->cartFinder->__invoke($cartId);
        $item = $this->itemFinder->__invoke($itemId);

        $cart->removeProduct($item);

        $cart = $this->cartPersister->__invoke($cart);

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

        $totalPrice = $totalPrice ?? 0;

        return new CartResponse(
            $cart->id(),
            $totalPrice,
            ...$itemResponses
        );
    }
}
