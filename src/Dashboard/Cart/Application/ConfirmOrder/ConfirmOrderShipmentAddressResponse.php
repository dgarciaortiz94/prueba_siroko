<?php

namespace App\Dashboard\Cart\Application\ConfirmOrder;

class ConfirmOrderShipmentAddressResponse
{
    public function __construct(
        private string $address,
        private string $location,
        private string $comunity,
        private string $zipCode
    ) {
    }

    /**
     * Get the value of address.
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Get the value of location.
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * Get the value of comunity.
     */
    public function getComunity(): string
    {
        return $this->comunity;
    }

    /**
     * Get the value of zipCode.
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }
}
