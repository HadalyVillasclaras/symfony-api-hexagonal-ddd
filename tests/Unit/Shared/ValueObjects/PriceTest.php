<?php

namespace App\Tests\Unit\MyDashboard\Shared\ValueObjects;

use App\MyDashboard\Shared\ValueObjects\Price;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $price = new Price(19.99);
        $this->assertInstanceOf(Price::class, $price);
    }

    public function testGetValueCorrectValue(): void
    {
        $price = new Price(19.99);
        $this->assertSame(19.99, $price->getValue());
    }

    public function testInvalidPrice(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Price cannot be negative');

        new Price(-1);
    }
}
