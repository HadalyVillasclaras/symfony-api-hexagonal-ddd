<?php

namespace App\Tests\Unit\MyDashboard\Shared\ValueObjects;

use App\MyDashboard\Shared\ValueObjects\Country;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
{
  public function testCanBeInstantiated(): void
  {
    $country = new Country("es");
    $this->assertInstanceOf(Country::class, $country);
  }

  public function testGetCodeCorrectValue(): void
  {
    $country = new Country("es");
    $this->assertSame("es", $country->getCode());
  }

  public function testGetCountryCorrectValue(): void
  {
    $country = new Country("es");
    $this->assertSame("Spain", $country->getCountry());
  }

  public function testInvalidCountryCode(): void
  {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('Country does not exist in our data base');

    new Country("invalid_code");
  }

  public function testValidNewCountry()
  {
    foreach (Country::getAllowedCountries() as $code => $countryName) {
      $country = new Country($code);
      $this->assertSame($code, $country->getCode());
      $this->assertSame($countryName, $country->getCountry());
    }
  }
}
