<?php

namespace App\Dashboard\Cart\Domain\Exception;

use Exception;

class ItemNotFoundInsideCartException extends Exception
{
    public function __construct() 
    {
        $this->message = "Item not found inside given cart";
    }
}
