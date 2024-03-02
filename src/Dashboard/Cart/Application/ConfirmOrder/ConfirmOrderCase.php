<?php

namespace App\Dashboard\Cart\Application\ConfirmOrder;

use App\Dashboard\Cart\Application\ConfirmOrder\Services\CartOrderConfirmer;
use App\Dashboard\Cart\Domain\Aggregate\CartId;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData\CartOrderAddressDataAddress;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData\CartOrderAddressDataComunity;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData\CartOrderAddressDataLocation;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData\CartOrderAddressDataZipCode;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderItemSnapshot\CartOrderItemSnapshot;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderPaymentData\CartOrderPaymentDataCard;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderUser\CartOrderUserId;
use App\Dashboard\Cart\Domain\Services\CartFinder;
use App\Shared\Domain\Bus\DomainEvent\IDomainEventBus;
use App\Shared\Domain\Services\CurrentUserRecovery;

class ConfirmOrderCase
{
    public function __construct(
        private CartFinder $cartFinder,
        private CartOrderConfirmer $cartOrderConfirmer,
        private IDomainEventBus $domainEventBus,
        private CurrentUserRecovery $currentUserRecovery
    ) {
    }

    public function __invoke(
        CartId $cartId,
        CartOrderPaymentDataCard $paymentCard,
        CartOrderAddressDataAddress $shipmentAddress,
        CartOrderAddressDataLocation $shipmentLocation,
        CartOrderAddressDataComunity $shipmentComunity,
        CartOrderAddressDataZipCode $shipmentZipCode
    ): ConfirmOrderResponse {
        $cart = $this->cartFinder->__invoke($cartId);

        $order = $cart->createOrder(
            $shipmentAddress,
            $shipmentLocation,
            $shipmentComunity,
            $shipmentZipCode,
            $paymentCard,
            ($user = $this->currentUserRecovery->__invoke()) ? new CartOrderUserId($user->getUserIdentifier()) : null
        );

        $this->cartOrderConfirmer->__invoke($cart);

        return new ConfirmOrderResponse(
            new ConfirmOrderShipmentAddressResponse(
                $order->shipmentAddressGetAddress(),
                $order->shipmentAddressLocation(),
                $order->shipmentAddressComunity(),
                $order->shipmentAddressZipCode()
            ),
            ...$order->itemSnapshots()->map(function (CartOrderItemSnapshot $orderItem) {
                return new ConfirmOrderItemSnapshotResponse(
                    $orderItem->id(),
                    $orderItem->itemId(),
                    $orderItem->price()
                );
            })
        );
    }
}
