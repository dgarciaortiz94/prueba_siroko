<?php

namespace App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderPaymentData;

class CartOrderPaymentData
{
    private CartOrderPaymentDataId $id;

    private CartOrderPaymentDataCard $card;

    private function __construct()
    {
        $this->id = new CartOrderPaymentDataId();
    }

    public static function create(
        CartOrderPaymentDataCard $card
    ): self {
        $self = new self();

        $self->card = $card;

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
     * Get the value of card.
     */
    public function card(): string
    {
        return $this->card->value();
    }
}
