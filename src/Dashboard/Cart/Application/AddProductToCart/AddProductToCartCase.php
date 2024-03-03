<?php

namespace App\Dashboard\Cart\Application\AddProductToCart;

use App\Dashboard\Cart\Application\Shared\CartItemResponse;
use App\Dashboard\Cart\Application\Shared\CartResponse;
use App\Dashboard\Cart\Domain\Aggregate\CartId;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartItemProductId;
use App\Dashboard\Cart\Domain\Services\CartFinder;
use App\Dashboard\Cart\Domain\Services\CartFirstAvailableProductItemFinder;
use App\Dashboard\Cart\Domain\Services\CartPersister;
use App\Shared\Domain\Bus\DomainEvent\IDomainEventBus;

class AddProductToCartCase
{
    public function __construct(
        private CartFinder $cartFinder,
        private CartFirstAvailableProductItemFinder $itemFinder,
        private CartPersister $cartPersister,
        private IDomainEventBus $domainEventBus
    ) {
    }

    public function __invoke(CartId $cartId, CartItemProductId $productId): CartResponse
    {
        $cart = $this->cartFinder->__invoke($cartId);
        $item = $this->itemFinder->__invoke($productId);

        $cart->addProduct($item);

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

        return new CartResponse(
            $cart->id(),
            $totalPrice,
            ...$itemResponses
        );
    }
}
