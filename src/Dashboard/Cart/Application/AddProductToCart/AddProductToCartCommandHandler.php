<?php

namespace App\Dashboard\Cart\Application\AddProductToCart;

use App\Dashboard\Cart\Domain\Aggregate\CartId;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartItemProductId;
use App\Shared\Domain\Bus\Command\ICommandResponse;

class AddProductToCartCommandHandler
{
    public function __construct(
        private AddProductToCartCase $addProductToCartCase
    ) {
    }

    public function __invoke(AddProductToCartCommand $addProductToCartCommand): ICommandResponse
    {
        return $this->addProductToCartCase->__invoke(
            new CartId($addProductToCartCommand->cartId()),
            new CartItemProductId($addProductToCartCommand->productId())
        );
    }
}
