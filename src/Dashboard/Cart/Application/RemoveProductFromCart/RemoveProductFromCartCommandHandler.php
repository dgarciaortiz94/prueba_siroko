<?php

namespace App\Dashboard\Cart\Application\RemoveProductFromCart;

use App\Dashboard\Cart\Domain\Aggregate\CartId;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemId;
use App\Shared\Domain\Bus\Command\ICommandResponse;

class RemoveProductFromCartCommandHandler
{
    public function __construct(
        private RemoveProductFromCartCase $removeProductFromCartCase
    ) {
    }

    public function __invoke(RemoveProductFromCartCommand $removeProductFromCartCommand): ICommandResponse
    {
        return $this->removeProductFromCartCase->__invoke(
            new CartId($removeProductFromCartCommand->cartId()),
            new CartItemId($removeProductFromCartCommand->itemId())
        );
    }
}
