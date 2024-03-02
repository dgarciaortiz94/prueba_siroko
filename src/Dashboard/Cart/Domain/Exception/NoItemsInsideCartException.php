<?php

namespace App\Dashboard\Cart\Domain\Exception;

class NoItemsInCartException extends \Exception
{
    public function __construct()
    {
        $this->message = 'Cannot create an order without items in the cart';
    }
}
