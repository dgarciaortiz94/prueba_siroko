<?php

namespace App\Dashboard\Cart\Domain\Services\Exception;

class NoAvailableItemsException extends \Exception
{
    public function __construct()
    {
        $this->message = 'No available items found';
    }
}
