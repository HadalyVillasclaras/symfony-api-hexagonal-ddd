<?php

namespace App\Tests\Unit\MyDashboard\Shared\ValueObjects;

use App\MyDashboard\Shared\ValueObjects\Language;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LanguageTest extends TestCase
{
  public function testValidNewLanguage()
  {
      $this->assertSame("es", (new Language("es"))->getCode());
      $this->assertSame("en", (new Language("en"))->getCode());
      $this->assertSame("fr", (new Language("fr"))->getCode());
      $this->assertSame("it", (new Language("it"))->getCode());
      $this->assertSame("ru", (new Language("ru"))->getCode());
      $this->assertSame("pt", (new Language("pt"))->getCode());
      $this->assertSame("ja", (new Language("ja"))->getCode());
  }

    public function testCanBeInstantiated(): void
    {
        $language = new Language("en");
        $this->assertInstanceOf(Language::class, $language);
    }

    public function testGetCodeCorrectValue(): void
    {
        $language = new Language("en");
        $this->assertSame("en", $language->getCode());
    }

    public function testGetLanguageCorrectValue(): void
    {
        $language = new Language("en");
        $this->assertSame("English", $language->getLanguage());
    }

    public function testInvalidLanguageCode(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Language does not exist');

        new Language("invalid_code");
    }
}
