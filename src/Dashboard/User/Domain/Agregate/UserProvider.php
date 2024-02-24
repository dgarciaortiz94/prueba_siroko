<?php

namespace App\Dashboard\User\Domain\Agregate;

use App\Shared\Domain\ValueObject\String\EnumerableValueObject;

readonly class UserProvider extends EnumerableValueObject
{
    public const APPLICATION = 'Application';
    public const GOOGLE = 'Google';

    protected function enumerables(): array
    {
        return [
            self::APPLICATION,
            self::GOOGLE,
        ];
    }
}
