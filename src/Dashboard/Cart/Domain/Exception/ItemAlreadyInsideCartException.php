<?php

namespace App\Dashboard\Cart\Domain\Exception;

use Exception;

class ItemAlreadyInsideCartException extends Exception
{
    public function __construct() 
    {
        $this->message = "Item already saved inside given cart";
    }
}
