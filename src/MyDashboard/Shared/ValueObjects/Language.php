<?php

namespace App\MyDashboard\Shared\Domain\ValueObject;

use App\MyDashboard\Shared\Domain\Dictionaries\LanguageCodes;
use App\MyDashboard\Shared\Domain\Exceptions\ValueObjects\InvalidLanguageException;
use Exception;

class Language
{
    private string $languageCode;
    private string $language;

    private static $languageCodes = [
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
        if (!$this->checkIfExists($languageCode)) {
            throw new Exception();
        }

        $this->languageCode = $languageCode;
    }

    private function checkIfExists(string $languageCode): ?bool
    {
        if (array_key_exists($languageCode, self::$languageCodes)) {
            $this->language = self::$languageCodes[$languageCode];
        }

        if ($this->language) {
            return true;
        }

        return false;
    }

    public function getLanguageCode(): ?string
    {
        return $this->languageCode;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }
}
