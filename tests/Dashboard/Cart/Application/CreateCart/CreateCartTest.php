<?php

namespace App\Tests\Dashboard\Cart\Application\CreateCart;

use App\Dashboard\Cart\Application\CreateCart\CreateCartCase;
use App\Dashboard\Cart\Application\CreateCart\CreateCartResponse;
use App\Dashboard\Cart\Domain\Services\CartCreator;
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
            new CartCreator($this->repository()),
            $this->eventBus()
        );

        $createCartResponse = $createCartCase->__invoke($cart);

        $this->assertEquals(CreateCartResponse::class, $createCartResponse::class);
    }
}
