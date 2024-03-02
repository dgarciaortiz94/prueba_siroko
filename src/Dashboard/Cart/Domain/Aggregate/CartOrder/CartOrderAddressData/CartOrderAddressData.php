<?php

namespace App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData;

class CartOrderAddressData
{
    private CartOrderAddressDataId $id;

    private CartOrderAddressDataAddress $address;

    private CartOrderAddressDataLocation $location;

    private CartOrderAddressDataComunity $comunity;

    private CartOrderAddressDataZipCode $zipCode;

    private function __construct()
    {
        $this->id = new CartOrderAddressDataId();
    }

    public static function create(
        CartOrderAddressDataAddress $address,
        CartOrderAddressDataLocation $location,
        CartOrderAddressDataComunity $comunity,
        CartOrderAddressDataZipCode $zipCode
    ): self {
        $self = new self();

        $self->address = $address;
        $self->location = $location;
        $self->comunity = $comunity;
        $self->zipCode = $zipCode;

        return $self;
    }

    /**
     * Get the value of id.
     */
    public function id(): string
    {
        return $this->id->value();
    }

    /**
     * Get the value of address.
     */
    public function address(): string
    {
        return $this->address->value();
    }

    /**
     * Get the value of location.
     */
    public function location(): string
    {
        return $this->location->value();
    }

    /**
     * Get the value of comunity.
     */
    public function comunity(): string
    {
        return $this->comunity->value();
    }

    /**
     * Get the value of zipCode.
     */
    public function zipCode(): string
    {
        return $this->zipCode->value();
    }
}
