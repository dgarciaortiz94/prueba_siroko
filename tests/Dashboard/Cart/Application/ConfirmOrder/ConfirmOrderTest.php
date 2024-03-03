<?php

namespace App\Tests\Dashboard\Cart\Application\ConfirmOrder;

use App\Dashboard\Cart\Application\ConfirmOrder\ConfirmOrderCase;
use App\Dashboard\Cart\Application\ConfirmOrder\ConfirmOrderResponse;
use App\Dashboard\Cart\Application\ConfirmOrder\Services\CartOrderConfirmer;
use App\Dashboard\Cart\Domain\Aggregate\CartId;
use App\Dashboard\Cart\Domain\Aggregate\CartItem\CartItemState;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData\CartOrderAddressDataAddress;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData\CartOrderAddressDataComunity;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData\CartOrderAddressDataLocation;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData\CartOrderAddressDataZipCode;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderPaymentData\CartOrderPaymentDataCard;
use App\Dashboard\Cart\Domain\Exception\NoItemsInCartException;
use App\Dashboard\Cart\Domain\Exception\OrderAlreadyCreatedForThisCartException;
use App\Dashboard\Cart\Domain\Services\CartFinder;
use App\Dashboard\Cart\Domain\Services\CartPersister;
use App\Shared\Domain\Services\CurrentUserRecovery;
use App\Shared\Domain\Validation\Payment\InvalidPaymentCardException;
use App\Tests\Dashboard\Cart\Application\AbstractCartApplicationMock;
use App\Tests\Dashboard\Cart\Domain\CartItemMother;
use App\Tests\Dashboard\Cart\Domain\CartMother;
use App\Tests\Dashboard\Cart\Domain\CartProductMother;
use PHPUnit\Framework\MockObject\MockObject;

class ConfirmOrderTest extends AbstractCartApplicationMock
{
    protected CurrentUserRecovery|MockObject|null $currentUserRecovery = null;

    /**
     * @test
     */
    public function shouldConfirmOrderSuccessfully()
    {
        $item = CartItemMother::create(
            product: CartProductMother::create()
        );

        $cart = CartMother::create($item);

        $currentUserRecovery = $this->currentUserRecovery();
        $repositoryCartFound = $this->repository();
        $repositoryCartSave = $this->repository();

        $currentUserRecovery
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(null);

        $repositoryCartFound
            ->expects($this->once())
            ->method('search')
            ->willReturn($cart);

        $repositoryCartSave->expects($this->once())
            ->method('save')
            ->willReturn($cart);

        $confirmOrder = new ConfirmOrderCase(
            new CartFinder($repositoryCartFound),
            new CartPersister($repositoryCartSave),
            $this->eventBus(),
            $currentUserRecovery
        );

        $orderResponse = $confirmOrder->__invoke(
            new CartId('018dec59-16b4-7529-8953-adf9194d5888'),
            new CartOrderPaymentDataCard('4485-2465-4898-2545'),
            new CartOrderAddressDataAddress('Calle Falsa 123'),
            new CartOrderAddressDataLocation('Alcorcón'),
            new CartOrderAddressDataComunity('Madrid'),
            new CartOrderAddressDataZipCode('28015'),
        );

        $this->assertEquals(ConfirmOrderResponse::class, $orderResponse::class);
        $this->assertEquals(CartItemState::SOLD, $cart->items()[0]->state());
    }

    /**
     * @test
     */
    public function shouldReturnNoItemsInCartException()
    {
        $item = CartItemMother::create(
            product: CartProductMother::create()
        );

        $cart = CartMother::create($item);
        $cart->removeProduct($item);

        $currentUserRecovery = $this->currentUserRecovery();
        $repositoryCartFound = $this->repository();
        $repositoryCartSave = $this->repository();

        $currentUserRecovery
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(null);

        $repositoryCartFound
            ->expects($this->once())
            ->method('search')
            ->willReturn($cart);

        $confirmOrder = new ConfirmOrderCase(
            new CartFinder($repositoryCartFound),
            new CartPersister($repositoryCartSave),
            $this->eventBus(),
            $currentUserRecovery
        );

        $this->expectException(NoItemsInCartException::class);

        $confirmOrder->__invoke(
            new CartId('018dec59-16b4-7529-8953-adf9194d5888'),
            new CartOrderPaymentDataCard('4485-2465-4898-2545'),
            new CartOrderAddressDataAddress('Calle Falsa 123'),
            new CartOrderAddressDataLocation('Alcorcón'),
            new CartOrderAddressDataComunity('Madrid'),
            new CartOrderAddressDataZipCode('28015'),
        );
    }

    /**
     * @test
     */
    public function shouldReturnInvalidPaymentCardException()
    {
        $currentUserRecovery = $this->currentUserRecovery();
        $repositoryCartFound = $this->repository();
        $repositoryCartSave = $this->repository();

        $confirmOrder = new ConfirmOrderCase(
            new CartFinder($repositoryCartFound),
            new CartPersister($repositoryCartSave),
            $this->eventBus(),
            $currentUserRecovery
        );

        $this->expectException(InvalidPaymentCardException::class);

        $confirmOrder->__invoke(
            new CartId('018dec59-16b4-7529-8953-adf9194d5888'),
            new CartOrderPaymentDataCard('GFDF-2465-4898-2545'),
            new CartOrderAddressDataAddress('Calle Falsa 123'),
            new CartOrderAddressDataLocation('Alcorcón'),
            new CartOrderAddressDataComunity('Madrid'),
            new CartOrderAddressDataZipCode('28015'),
        );
    }

    /**
     * @test
     */
    public function shouldOrderAlreadyCreatedByThisCartException()
    {
        $item = CartItemMother::create(
            product: CartProductMother::create()
        );

        $cart = CartMother::create($item);

        $currentUserRecovery = $this->currentUserRecovery();
        $repositoryCartFound = $this->repository();
        $repositoryCartSave = $this->repository();

        $currentUserRecovery
            ->expects($this->exactly(2))
            ->method('__invoke')
            ->willReturn(null);

        $repositoryCartFound
            ->expects($this->exactly(2))
            ->method('search')
            ->willReturn($cart);

        $repositoryCartSave->expects($this->once())
            ->method('save')
            ->willReturn($cart);

        $confirmOrder = new ConfirmOrderCase(
            new CartFinder($repositoryCartFound),
            new CartPersister($repositoryCartSave),
            $this->eventBus(),
            $currentUserRecovery
        );

        $confirmOrder->__invoke(
            new CartId('018dec59-16b4-7529-8953-adf9194d5888'),
            new CartOrderPaymentDataCard('4485-2465-4898-2545'),
            new CartOrderAddressDataAddress('Calle Falsa 123'),
            new CartOrderAddressDataLocation('Alcorcón'),
            new CartOrderAddressDataComunity('Madrid'),
            new CartOrderAddressDataZipCode('28015'),
        );

        $this->expectException(OrderAlreadyCreatedForThisCartException::class);

        $confirmOrder->__invoke(
            new CartId('018dec59-16b4-7529-8953-adf9194d5888'),
            new CartOrderPaymentDataCard('4485-2465-4898-2545'),
            new CartOrderAddressDataAddress('Calle Falsa 123'),
            new CartOrderAddressDataLocation('Alcorcón'),
            new CartOrderAddressDataComunity('Madrid'),
            new CartOrderAddressDataZipCode('28015'),
        );
    }

    protected function currentUserRecovery(): CurrentUserRecovery|MockObject
    {
        $currentUserRecovery = $this->getMockBuilder(CurrentUserRecovery::class)->disableOriginalConstructor()->getMock();

        return $this->currentUserRecovery ??= $currentUserRecovery;
    }
}
