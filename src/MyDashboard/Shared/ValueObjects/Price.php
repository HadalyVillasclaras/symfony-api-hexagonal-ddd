<?php

namespace App\MyDashboard\Shared\Domain\ValueObject;

use InvalidArgumentException;

class Price
{
    private float $value;

    public function __construct(float $value)
    {

        $this->validateValue($value);
        $this->value = round($value, 2);
    }

    private function validateValue(float $value): void
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Price cannot be negative');
        }
    }

    public function getValue(): float
    {
        return $this->value;
    }
}