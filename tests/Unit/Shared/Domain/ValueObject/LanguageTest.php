<?php

declare(strict_types=1);

namespace App\Tests\Unit\MyDashboard\Shared\Domain\ValueObject;

use App\MyDashboard\Shared\Domain\Exceptions\ValueObjects\InvalidLanguageException;
use App\MyDashboard\Shared\Domain\ValueObject\Language;
use  PHPUnit\Framework\TestCase;

final class LanguageTest extends TestCase
{
    public function testValidLanguage()
    {
        $this->assertSame("es", (new Language("es"))->value());
        $this->assertSame("en", (new Language("en"))->value());
        $this->assertSame("fr", (new Language("fr"))->value());
        $this->assertSame("de", (new Language("de"))->value());
        $this->assertSame("nl", (new Language("nl"))->value());
    }

    public function testInvalidLanguageUppercase()
    {
        $this->expectException(InvalidLanguageException::class);

        new Language("ES");
    }

    public function testInvalidLanguageNotInArray()
    {
        $this->expectException(InvalidLanguageException::class);

        new Language("yz");
    }

    public function testInvalidLanguageSymbol()
    {
        $this->expectException(InvalidLanguageException::class);

        new Language("es-");
    }
}
