<?php

namespace App\Tests\Dashboard\Cart\Application\AddProductToCart;

use App\Dashboard\Cart\Application\AddProductToCart\AddProductToCartCase;
use App\Dashboard\Cart\Application\AddProductToCart\Services\CartProductAggregator;
use App\Dashboard\Cart\Application\Shared\CartResponse;
use App\Dashboard\Cart\Domain\Aggregate\CartId;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemProduct\CartItemProductId;
use App\Dashboard\Cart\Domain\Exception\NoAvailableItemsException;
use App\Dashboard\Cart\Domain\Services\CartFinder;
use App\Dashboard\Cart\Domain\Services\CartFirstAvailableProductItemFinder;
use App\Tests\Dashboard\Cart\Application\AbstractCartApplicationMock;
use App\Tests\Dashboard\Cart\Domain\CartItemMother;
use App\Tests\Dashboard\Cart\Domain\CartMother;
use App\Tests\Dashboard\Cart\Domain\CartProductMother;
use Doctrine\Common\Collections\ArrayCollection;

class AddProductToCartTest extends AbstractCartApplicationMock
{
    /**
     * @test
     */
    public function shouldAddProductToCartSuccessfully()
    {
        $item = CartItemMother::create(
            product: CartProductMother::create()
        );
        $item2Id = '018dec02-29da-7853-9de9-c76c45ffee8e';
        $item2 = CartItemMother::create(
            id: $item2Id,
            tid: '564HG6JHG53H65HJG65G345G6H6',
            product: CartProductMother::create()
        );

        $cart = CartMother::create($item);

        $repositoryCartFound = $this->repository();
        $repositoryProductEmptyReturn = $this->repository();
        $repositoryCartSave = $this->repository();

        $repositoryCartFound
            ->expects($this->once())
            ->method('search')
            ->willReturn($cart);

        $repositoryProductEmptyReturn
            ->expects($this->once())
            ->method('searchAvailableProductItem')
            ->willReturn(new ArrayCollection([$item2, $item]));

        $repositoryCartSave->expects($this->once())
            ->method('save')
            ->willReturn($cart);

        $addItemToCartCase = new AddProductToCartCase(
            new CartFinder($repositoryCartFound),
            new CartFirstAvailableProductItemFinder($repositoryProductEmptyReturn),
            new CartProductAggregator($repositoryCartSave),
            $this->eventBus()
        );

        $cartResponse = $addItemToCartCase->__invoke(
            new CartId('018dec59-16b4-7529-8953-adf9194d5888'),
            new CartItemProductId('018dec59-4f24-7e39-8d82-e73c7be3ca24')
        );

        $this->assertEquals(CartResponse::class, $cartResponse::class);
        $this->assertCount(2, $cartResponse->items());
        $this->assertEquals($item2Id, $cartResponse->items()[1]->id());
    }

    /**
     * @test
     */
    public function shouldReturnNoAvailableItemsException()
    {
        $item = CartItemMother::create(
            product: CartProductMother::create()
        );
        $cart = CartMother::create($item);

        $repositoryCartFound = $this->repository();
        $repositoryProductEmptyReturn = $this->repository();

        $repositoryCartFound
            ->expects($this->once())
            ->method('search')
            ->willReturn($cart);

        $repositoryProductEmptyReturn
            ->expects($this->once())
            ->method('searchAvailableProductItem')
            ->willReturn(new ArrayCollection([]));

        $addItemToCartCase = new AddProductToCartCase(
            new CartFinder($repositoryCartFound),
            new CartFirstAvailableProductItemFinder($repositoryProductEmptyReturn),
            new CartProductAggregator($this->repository()),
            $this->eventBus()
        );

        $this->expectException(NoAvailableItemsException::class);

        $addItemToCartCase->__invoke(
            new CartId('018dec59-16b4-7529-8953-adf9194d5888'),
            new CartItemProductId('018dec59-4f24-7e39-8d82-e73c7be3ca24')
        );
    }
}
