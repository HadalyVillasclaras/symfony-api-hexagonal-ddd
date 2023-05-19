<?php

namespace App\MyDashboard\Shared\ValueObjects;

use InvalidArgumentException;

class BookCategory
{
    private string $category;

    private static $allowedCategories = [
        "Architecture",
        "Visual Arts",
        "Cultural Studies",
        "Postdigital",
        "Politics & Society",
        "Contemporary Art"
    ];

    public function __construct(string $category)
    {
        $this->checkIfExists($category);

        $this->category = $category;
    }

    private function checkIfExists(string $category): void
    {
        if (!in_array($category, self::$allowedCategories)) {
            throw new InvalidArgumentException('Book category does not exist');
        }
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }
}
