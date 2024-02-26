<?php

namespace App\Dashboard\Cart\Application\CreateCart;

use App\Dashboard\Cart\Domain\Aggregate\Cart;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartItemProductId;
use App\Dashboard\Cart\Domain\Services\CartProductFinder;
use App\Shared\Domain\Bus\Command\ICommandHandler;
use App\Shared\Domain\Bus\Command\ICommandResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CreateCartCommandHandler implements ICommandHandler
{
    public function __construct(
        private CreateCartCase $createCartCase,
        private CartProductFinder $productFinder,
        private TokenStorageInterface $tokenStorage
    ) {
    }

    public function __invoke(CreateCartCommand $createCartCommand): ICommandResponse
    {
        $product = $this->productFinder->__invoke(new CartItemProductId($createCartCommand->productId));
        $currentUser = $this->tokenStorage->getToken()->getUser() ?? null;

        $cart = Cart::create(
            $product[0],
            $currentUser
        );

        return $this->createCartCase->__invoke($cart);
    }
}
