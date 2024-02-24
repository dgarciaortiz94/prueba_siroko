<?php

namespace App\Dashboard\User\Domain\Agregate\Exceptions;

class PasswordNotEqualsException extends \Exception
{
    public function __construct()
    {
        $this->message = 'Passwords must be the same';
    }
}
