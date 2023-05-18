<?php

namespace App\MyDashboard\Shared\Domain\ValueObject;

use App\MyDashboard\Shared\Domain\Dictionaries\allowedLanguages;
use App\MyDashboard\Shared\Domain\Exceptions\ValueObjects\InvalidLanguageException;
use InvalidArgumentException;

class Language
{
    private string $languageCode;
    private string $language;

    private static $allowedLanguages = [
        "es" => "Spanish",
        "en" => "English",
        "fr" => "French",
        "it" => "Italian",
        "ru" => "Russian",
        "pt" => "Portuguese",
        "ja" => "Japanese"
    ];

    public function __construct(string $languageCode)
    {
        $this->checkIfExists($languageCode);

        $this->languageCode = $languageCode;
        $this->language = self::$allowedLanguages[$languageCode];

    }

    private function checkIfExists(string $languageCode): void
    {
        if (!array_key_exists($languageCode, self::$allowedLanguages)) {
            throw new InvalidArgumentException('Language does not exist');
        }
    }

    public function getCode(): ?string
    {
        return $this->languageCode;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }
}
