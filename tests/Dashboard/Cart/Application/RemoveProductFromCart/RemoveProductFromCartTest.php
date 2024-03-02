<?php

namespace App\Tests\Dashboard\Cart\Application\RemoveProductFromCart;

use App\Dashboard\Cart\Application\RemoveProductFromCart\RemoveProductFromCartCase;
use App\Dashboard\Cart\Application\RemoveProductFromCart\Services\CartProductRemover;
use App\Dashboard\Cart\Application\Shared\CartResponse;
use App\Dashboard\Cart\Domain\Aggregate\CartId;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemId;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemState;
use App\Dashboard\Cart\Domain\Exception\ItemNotFoundInsideCartException;
use App\Dashboard\Cart\Domain\Services\CartFinder;
use App\Dashboard\Cart\Domain\Services\CartItemFinder;
use App\Tests\Dashboard\Cart\Application\AbstractCartApplicationMock;
use App\Tests\Dashboard\Cart\Domain\CartItemMother;
use App\Tests\Dashboard\Cart\Domain\CartMother;
use App\Tests\Dashboard\Cart\Domain\CartProductMother;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RemoveProductFromCartTest extends AbstractCartApplicationMock
{
    /**
     * @test
     */
    public function shouldRemoveProductFromCartSuccessfully()
    {
        $item = CartItemMother::create(
            product: CartProductMother::create()
        );

        $cart = CartMother::create($item);

        $repositoryCartFound = $this->repository();
        $repositoryItemFound = $this->repository();
        $repositoryCartSave = $this->repository();

        $repositoryCartFound
            ->expects($this->once())
            ->method('search')
            ->willReturn($cart);

        $repositoryItemFound
            ->expects($this->once())
            ->method('searchItem')
            ->willReturn($item);

        $repositoryCartSave->expects($this->once())
            ->method('save')
            ->willReturn($cart);

        $removeItemFromCartCase = new RemoveProductFromCartCase(
            new CartFinder($repositoryCartFound),
            new CartItemFinder($repositoryItemFound),
            new CartProductRemover($repositoryCartSave),
            $this->eventBus()
        );

        $cartItem = $cart->items()[0];

        $cartResponse = $removeItemFromCartCase->__invoke(
            new CartId($cart->items()[0]->id()),
            new CartItemId('018dec59-4f24-7e39-8d82-e73c7be3ca24')
        );

        $this->assertEquals(CartResponse::class, $cartResponse::class);
        $this->assertCount(0, $cartResponse->getItems());
        $this->assertEquals(CartItemState::AVAILABLE, $cartItem->state());
    }

    /**
     * @test
     */
    public function shoudReturnItemNotFoundInsideCartException()
    {
        $item = CartItemMother::create(
            product: CartProductMother::create()
        );
        $item2 = CartItemMother::create(
            id: '018dec02-29da-7853-9de9-c76c45ffee8e',
            tid: '564HG6JHG53H65HJG65G345G6H6',
            product: CartProductMother::create()
        );

        $cart = CartMother::create($item);

        $repositoryCartFound = $this->repository();
        $repositoryItemFound = $this->repository();
        $repositoryCartSave = $this->repository();

        $repositoryCartFound
            ->expects($this->once())
            ->method('search')
            ->willReturn($cart);

        $repositoryItemFound
            ->expects($this->once())
            ->method('searchItem')
            ->willReturn($item2);

        $addItemToCartCase = new RemoveProductFromCartCase(
            new CartFinder($repositoryCartFound),
            new CartItemFinder($repositoryItemFound),
            new CartProductRemover($repositoryCartSave),
            $this->eventBus()
        );

        $this->expectException(ItemNotFoundInsideCartException::class);

        $addItemToCartCase->__invoke(
            new CartId('018dec59-16b4-7529-8953-adf9194d5888'),
            new CartItemId('018dec59-4f24-7e39-8d82-e73c7be3ca24')
        );
    }

    /**
     * @test
     */
    public function shouldReturnNotFoundHttpException()
    {
        $item = CartItemMother::create(
            product: CartProductMother::create()
        );

        $cart = CartMother::create($item);

        $repositoryCartFound = $this->repository();
        $repositoryNoItemFound = $this->repository();
        $repositoryCartSave = $this->repository();

        $repositoryCartFound
            ->expects($this->once())
            ->method('search')
            ->willReturn($cart);

        $repositoryNoItemFound
            ->expects($this->once())
            ->method('searchItem')
            ->willReturn(null);

        $addItemToCartCase = new RemoveProductFromCartCase(
            new CartFinder($repositoryCartFound),
            new CartItemFinder($repositoryNoItemFound),
            new CartProductRemover($repositoryCartSave),
            $this->eventBus()
        );

        $this->expectException(NotFoundHttpException::class);

        $addItemToCartCase->__invoke(
            new CartId('018dec59-16b4-7529-8953-adf9194d5888'),
            new CartItemId('018dec59-4f24-7e39-8d82-e73c7be3ca24')
        );
    }
}
