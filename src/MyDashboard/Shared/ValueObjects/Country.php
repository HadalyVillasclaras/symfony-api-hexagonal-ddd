<?php

namespace App\MyDashboard\Shared\ValueObjects;

use InvalidArgumentException;

class Country
{
  private string $countryCode;
  private string $country;

  private static $allowedCountries = [
    "es" => "Spain",
    "fr" => "France",
    "uk" => "United Kingdom",
    "de" => "Germany",
    "it" => "Italy",
    "jp" => "Japan",
    "cn" => "China",
    "ru" => "Russia",
    "us" => "United States",
    "br" => "Brazil",
    "in" => "India"
  ];

  public function __construct(string $countryCode)
  {
    $this->checkIfExists($countryCode);

    $this->countryCode = $countryCode;
    $this->country = self::$allowedCountries[$countryCode];
  }

  private function checkIfExists(string $countryCode): void
  {
    if (!array_key_exists($countryCode, self::$allowedCountries)) {
      throw new InvalidArgumentException('Country does not exist in our data base');
    }
  }

  public function getCode(): ?string
  {
    return $this->countryCode;
  }

  public function getCountry(): ?string
  {
    return $this->country;
  }

  public static function getAllowedCountriesCodes(): array
{
    return array_keys(self::$allowedCountries);
}

public static function getAllowedCountries(): array
{
    return self::$allowedCountries;
}

}
