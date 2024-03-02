<?php

namespace App\Dashboard\Cart\Domain\Aggregate\CartOrder;

use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData\CartOrderAddressData;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData\CartOrderAddressDataAddress;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData\CartOrderAddressDataComunity;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData\CartOrderAddressDataLocation;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderAddressData\CartOrderAddressDataZipCode;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderItemSnapshot\CartOrderItemSnapshot;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderPaymentData\CartOrderPaymentData;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderPaymentData\CartOrderPaymentDataCard;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderUser\CartOrderUser;
use App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderUser\CartOrderUserId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class CartOrder
{
    private CartOrderId $id;

    private Collection $itemSnapshots;

    private CartOrderAddressData $shipmentAddress;

    private CartOrderPaymentData $paymentData;

    private ?CartOrderUser $user;

    private \DateTimeInterface $createdAt;

    private function __construct()
    {
        $this->id = new CartOrderId();
        $this->itemSnapshots = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public static function create(
        CartOrderAddressDataAddress $shipmentAddress,
        CartOrderAddressDataLocation $shipmenLocation,
        CartOrderAddressDataComunity $shipmenComunity,
        CartOrderAddressDataZipCode $shipmenZipCode,
        CartOrderPaymentDataCard $card,
        CartOrderUserId $userId = null,
        ?CartOrderItemSnapshot ...$itemSnapshots
    ): self {
        $self = new self();

        $self->itemSnapshots = new ArrayCollection($itemSnapshots);
        $self->shipmentAddress = CartOrderAddressData::create(
            $shipmentAddress,
            $shipmenLocation,
            $shipmenComunity,
            $shipmenZipCode
        );
        $self->paymentData = CartOrderPaymentData::create($card);
        $self->user = ($userId) ? CartOrderUser::create($userId) : null;

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
     * Get the value of itemSnapshots.
     */
    public function itemSnapshots(): Collection
    {
        return $this->itemSnapshots;
    }

    /**
     * Get the value of shipmentAddress address.
     */
    public function shipmentAddressGetAddress(): string
    {
        return $this->shipmentAddress->address();
    }

    /**
     * Get the value of shipmentAddress location.
     */
    public function shipmentAddressLocation(): string
    {
        return $this->shipmentAddress->location();
    }

    /**
     * Get the value of shipmentAddress comunity.
     */
    public function shipmentAddressComunity(): string
    {
        return $this->shipmentAddress->comunity();
    }

    /**
     * Get the value of shipmentAddress zip code.
     */
    public function shipmentAddressZipCode(): string
    {
        return $this->shipmentAddress->zipCode();
    }

    /**
     * Get the value of paymentData.
     */
    public function paymentCard(): string
    {
        return $this->paymentData->card();
    }
}
