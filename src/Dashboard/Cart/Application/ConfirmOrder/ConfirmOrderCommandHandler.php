<?php

namespace App\Dashboard\Cart\Application\ConfirmOrder;

use App\Dashboard\Cart\Domain\Aggregate\CartId;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData\CartOrderAddressDataAddress;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData\CartOrderAddressDataComunity;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData\CartOrderAddressDataLocation;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData\CartOrderAddressDataZipCode;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderPaymentData\CartOrderPaymentDataCard;
use App\Shared\Domain\Bus\Command\ICommandResponse;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
class ConfirmOrderCommandHandler
{
    public function __construct(
        private ConfirmOrderCase $confirmOrderCase
    ) {
    }

    public function __invoke(ConfirmOrderCommand $confirmOrderCommand): ICommandResponse
    {
        return $this->confirmOrderCase->__invoke(
            new CartId($confirmOrderCommand->cartId()),
            new CartOrderPaymentDataCard($confirmOrderCommand->paymentCard()),
            new CartOrderAddressDataAddress($confirmOrderCommand->shipmentAddress()),
            new CartOrderAddressDataLocation($confirmOrderCommand->shipmentLocation()),
            new CartOrderAddressDataComunity($confirmOrderCommand->shipmentComunity()),
            new CartOrderAddressDataZipCode($confirmOrderCommand->shipmentZipCode())
        );
    }
}
