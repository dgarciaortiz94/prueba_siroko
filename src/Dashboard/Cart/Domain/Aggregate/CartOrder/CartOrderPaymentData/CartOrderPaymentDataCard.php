<?php

namespace App\Dashboard\Cart\Domain\Aggregate\CartOrder\CartOrderPaymentData;

use App\Shared\Domain\Validation\Payment\PaymentCardValidator;
use App\Shared\Domain\ValueObject\String\StringValueObject;

readonly class CartOrderPaymentDataCard extends StringValueObject
{
    public function __construct(string $value)
    {
        $this->validate($value);

        parent::__construct($value);
    }

    private function validate(string $value)
    {
        PaymentCardValidator::validate($value);
    }
}
