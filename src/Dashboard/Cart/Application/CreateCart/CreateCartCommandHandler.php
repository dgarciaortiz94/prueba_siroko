<?php

namespace App\Dashboard\Cart\Application\CreateCart;

use App\Dashboard\Cart\Domain\Aggregate\Cart;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartItemProductId;
use App\Dashboard\Cart\Domain\Services\CartFirstAvailableProductItemFinder;
use App\Shared\Domain\Bus\Command\ICommandHandler;
use App\Shared\Domain\Bus\Command\ICommandResponse;
use App\Shared\Domain\Services\CurrentUserRecovery;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
class CreateCartCommandHandler implements ICommandHandler
{
    public function __construct(
        private CreateCartCase $createCartCase,
        private CartFirstAvailableProductItemFinder $itemFinder,
        private CurrentUserRecovery $currentUserRecovery
    ) {
    }

    public function __invoke(CreateCartCommand $createCartCommand): ICommandResponse
    {
        $item = $this->itemFinder->__invoke(new CartItemProductId($createCartCommand->productId()));
        $currentUser = $this->currentUserRecovery->__invoke() ?? null;

        $cart = Cart::create(
            $item,
            $currentUser
        );

        return $this->createCartCase->__invoke($cart);
    }
}
