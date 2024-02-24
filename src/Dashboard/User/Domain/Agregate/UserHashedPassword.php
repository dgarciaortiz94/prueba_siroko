<?php

namespace App\Dashboard\User\Domain\Agregate;

use App\Shared\Domain\ValueObject\String\StringValueObject;

readonly class UserHashedPassword extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }

    public function equals(UserHashedPassword $password): bool
    {
        return $this->value() === $password->value();
    }
}
