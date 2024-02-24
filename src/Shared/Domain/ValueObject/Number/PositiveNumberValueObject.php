<?php

namespace App\Shared\Domain\ValueObject\Number;

use SebastianBergmann\LinesOfCode\NegativeValueException;

abstract readonly class PositiveNumberValueObject
{
    protected float $value;

    public function __construct(float $value)
    {
        $this->setValue($value);
    }

    public function value(): float
    {
        return $this->value;
    }

    private function setValue(string $value)
    {
        $this->validate($value);

        $this->value = $value;

        return $this;
    }

    private function validate(float $value): void
    {
        if ($value < 0) {
            throw new NegativeValueException('Number must not be negative');
        }
    }
}
