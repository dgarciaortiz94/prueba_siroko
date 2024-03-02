<?php

namespace App\Dashboard\Cart\Application\ConfirmOrder;

use App\Shared\Domain\Bus\Command\ICommand;

class ConfirmOrderCommand implements ICommand
{
    public function __construct(
        private string $cartId,
        private string $paymentCard,
        private string $shipmentAddress,
        private string $shipmentLocation,
        private string $shipmentComunity,
        private string $shipmentZipCode
    ) {
    }

    /**
     * Get the value of cartId.
     */
    public function cartId(): string
    {
        return $this->cartId;
    }

    /**
     * Get the value of paymentCard.
     */
    public function paymentCard(): string
    {
        return $this->paymentCard;
    }

    /**
     * Get the value of shipmentAddress.
     */
    public function shipmentAddress(): string
    {
        return $this->shipmentAddress;
    }

    /**
     * Get the value of shipmentLocation.
     */
    public function shipmentLocation(): string
    {
        return $this->shipmentLocation;
    }

    /**
     * Get the value of shipmentComunity.
     */
    public function shipmentComunity(): string
    {
        return $this->shipmentComunity;
    }

    /**
     * Get the value of shipmentZipCode.
     */
    public function shipmentZipCode(): string
    {
        return $this->shipmentZipCode;
    }
}
