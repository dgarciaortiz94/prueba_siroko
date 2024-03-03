<?php

namespace App\Dashboard\Cart\Application\ConfirmOrder;

use App\Shared\Domain\Bus\Command\ICommand;
use Symfony\Component\Validator\Constraints as Assert;

class ConfirmOrderCommand implements ICommand
{
    public function __construct(
        private ?string $cartId,
        #[Assert\NotNull(), Assert\Type('string'), Assert\Regex(
            pattern: '/^\d{4}-\d{4}-\d{4}-\d{4}$/',
            message: 'Payment card must be format "dddd-dddd-dddd-dddd" and must be contain only numbers'
        )]
        private string $paymentCard,
        #[Assert\NotNull(), Assert\Type('string'), Assert\Length(max: 150)]
        private string $shipmentAddress,
        #[Assert\NotNull(), Assert\Type('string'), Assert\Length(max: 30)]
        private string $shipmentLocation,
        #[Assert\NotNull(), Assert\Type('string'), Assert\Length(max: 40)]
        private string $shipmentComunity,
        #[Assert\NotNull(), Assert\Type('string'), Assert\Length(max: 5)]
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
     * Set the value of cartId.
     */
    public function setCartId(string $cartId): self
    {
        $this->cartId = $cartId;

        return $this;
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
