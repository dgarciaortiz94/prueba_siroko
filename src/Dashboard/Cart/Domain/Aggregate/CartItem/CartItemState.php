<?php

namespace App\Dashboard\Cart\Domain\Aggregate\CartItem;

use App\Shared\Domain\ValueObject\String\EnumerableValueObject;

readonly class CartItemState extends EnumerableValueObject
{
    public const AVAILABLE = 1;
    public const RESERVED = 2;
    public const SOLD = 3;

    protected function enumerables(): array
    {
        return [
            self::AVAILABLE,
            self::RESERVED,
            self::SOLD,
        ];
    }
}
