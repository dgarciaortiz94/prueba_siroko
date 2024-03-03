<?php

namespace App\Dashboard\Cart\Domain\Exception;

class OrderAlreadyCreatedForThisCartException extends \Exception
{
    public function __construct()
    {
        $this->message = 'An order was already created for this cart';
    }
}
