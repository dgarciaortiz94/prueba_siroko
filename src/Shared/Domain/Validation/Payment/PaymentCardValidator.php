<?php

namespace App\Shared\Domain\Validation\Payment;

readonly class PaymentCardValidator
{
    public const REGEX = '/^\d{4}-\d{4}-\d{4}-\d{4}$/';

    public static function validate(mixed $paymentCard): void
    {
        if (!preg_match(self::REGEX, $paymentCard)) {
            throw new InvalidPaymentCardException();
        }
    }
}
