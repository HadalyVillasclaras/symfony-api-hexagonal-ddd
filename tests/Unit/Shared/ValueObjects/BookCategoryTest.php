<?php

namespace App\Tests\Unit\MyDashboard\Shared\ValueObjects;

use App\MyDashboard\Shared\ValueObjects\BookCategory;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class BookCategoryTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $bookCategory = new BookCategory("Politics & Society");
        $this->assertInstanceOf(BookCategory::class, $bookCategory);
    }

    public function testGetCategoryCorrectValue(): void
    {
        $bookCategory = new BookCategory("Politics & Society");
        $this->assertSame("Politics & Society", $bookCategory->getCategory());
    }

    public function testInvalidBookCategory(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Book category does not exist');

        new BookCategory("Invalid Category");
    }
}
