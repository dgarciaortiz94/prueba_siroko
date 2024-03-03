<?php

namespace App\Shared\Domain\Validation\Payment;

class InvalidPaymentCardException extends \Exception
{
    public function __construct()
    {
        $this->message = 'Payment card must be format "dddd-dddd-dddd-dddd" and must be contain only numbers';
    }
}
