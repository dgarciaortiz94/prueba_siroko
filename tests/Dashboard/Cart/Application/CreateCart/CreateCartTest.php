<?php

namespace App\Tests\Dashboard\Cart\Application\CreateCart;

use App\Dashboard\Cart\Application\CreateCart\CreateCartCase;
use App\Dashboard\Cart\Application\Shared\CartResponse;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemState;
use App\Dashboard\Cart\Domain\Services\CartCreator;
use App\Dashboard\Cart\Domain\Services\CartPersister;
use App\Tests\Dashboard\Cart\Application\AbstractCartApplicationMock;
use App\Tests\Dashboard\Cart\Domain\CartItemMother;
use App\Tests\Dashboard\Cart\Domain\CartMother;

class CreateCartTest extends AbstractCartApplicationMock
{
    /**
     * @test
     */
    public function shouldCreateCartSuccessfully()
    {
        $cart = CartMother::create(
            CartItemMother::create(),
        );

        $this->repository()->expects($this->once())
            ->method('save')
            ->willReturn($cart);

        $createCartCase = new CreateCartCase(
            new CartPersister($this->repository()),
            $this->eventBus()
        );

        $cartResponse = $createCartCase->__invoke($cart);

        $this->assertEquals(CartResponse::class, $cartResponse::class);
        $this->assertEquals(CartItemState::RESERVED, $cart->items()[0]->state());
    }
}
