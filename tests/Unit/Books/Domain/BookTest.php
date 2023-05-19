<?php

namespace App\Tests\Unit\Books\Domain;

use App\MyDashboard\Books\Domain\Book;
use App\MyDashboard\Shared\ValueObjects\BookCategory;
use App\MyDashboard\Shared\ValueObjects\Country;
use App\MyDashboard\Shared\ValueObjects\Language;
use App\MyDashboard\Shared\ValueObjects\Price;
use PHPUnit\Framework\TestCase;

final class BookTest extends TestCase
{
    private Book $validBook;

    public function setUp(): void
    {
        $title = 'Book Title';
        $subtitle = 'Book Subtitle';
        $author = 'Author Name';
        $year = 2023;
        $category = new BookCategory('Architecture');
        $language = new Language('en');
        $country = new Country('fr');
        $pages = 200;
        $price = new Price(19.95);
        $link = 'https://example.com';
        $status = 'Available';
        $isbn = '978-3-16-148410-0';
        $url = 'https://example.com/book.jpg';
        $description = 'A book description.';

        $this->validBook = new Book(
            $title,
            $subtitle,
            $author,
            $year,
            $category,
            $language,
            $country,
            $pages,
            $price,
            $link,
            $status,
            $isbn,
            $url,
            $description
        );
    }

    public function testValidBook(): void
    {
        $this->assertInstanceOf(Book::class, $this->validBook);
        $this->assertEquals("Book Title", $this->validBook->getTitle());
        $this->assertEquals("Book Subtitle", $this->validBook->getSubtitle());
        $this->assertEquals("Author Name", $this->validBook->getAuthor());
        $this->assertEquals(2023, $this->validBook->getYear());
        $this->assertEquals("Architecture", $this->validBook->getCategory());
        $this->assertEquals("en", $this->validBook->getLanguage());
        $this->assertEquals("France", $this->validBook->getCountry());
        $this->assertEquals(200, $this->validBook->getPages());
        $this->assertEquals(19.95, $this->validBook->getPrice());
        $this->assertEquals("https://example.com", $this->validBook->getLink());
        $this->assertEquals("Available", $this->validBook->getStatus());
        $this->assertEquals("978-3-16-148410-0", $this->validBook->getIsbn());
        $this->assertEquals("https://example.com/book.jpg", $this->validBook->getUrl());
        $this->assertEquals("A book description.", $this->validBook->getDescription());
    }

    public function testTitleCanBeChanged(): void
    {
        $this->validBook->setTitle("New Title");
        $this->assertEquals("New Title", $this->validBook->getTitle());
    }

    public function testSubtitleCanBeChanged(): void
    {
        $this->validBook->setSubtitle("New Subtitle");
        $this->assertEquals("New Subtitle", $this->validBook->getSubtitle());
    }

    public function testAuthorCanBeChanged(): void
    {
        $this->validBook->setAuthor("New Author");
        $this->assertEquals("New Author", $this->validBook->getAuthor());
    }

    public function testYearCanBeChanged(): void
    {
        $this->validBook->setYear(2024);
        $this->assertEquals(2024, $this->validBook->getYear());
    }

    public function testCategoryCanBeChanged(): void
    {
        $this->validBook->setCategory(new BookCategory("Visual Arts"));
        $this->assertEquals("Visual Arts", $this->validBook->getCategory());
    }

    public function testLanguageCanBeChanged(): void
    {
        $this->validBook->setLanguage(new Language("es"));
        $this->assertEquals("es", $this->validBook->getLanguage());
    }

    public function testCountryCanBeChanged(): void
    {
        $this->validBook->setCountry(new Country("uk"));
        $this->assertEquals("United Kingdom", $this->validBook->getCountry());
    }

    public function testPagesCanBeChanged(): void
    {
        $this->validBook->setPages(300);
        $this->assertEquals(300, $this->validBook->getPages());
    }

    public function testPriceCanBeChanged(): void
    {
        $this->validBook->setPrice(new Price(29.99));
        $this->assertEquals(29.99, $this->validBook->getPrice());
    }

    public function testLinkCanBeChanged(): void
    {
        $this->validBook->setLink("http://newlink.com");
        $this->assertEquals("http://newlink.com", $this->validBook->getLink());
    }

    public function testStatusCanBeChanged(): void
    {
        $this->validBook->setStatus("Not Available");
        $this->assertEquals("Not Available", $this->validBook->getStatus());
    }

    public function testIsbnCanBeChanged(): void
    {
        $this->validBook->setIsbn("978-3-16-148410-1");
        $this->assertEquals("978-3-16-148410-1", $this->validBook->getIsbn());
    }

    public function testUrlCanBeChanged(): void
    {
        $this->validBook->setUrl("http://newurl.com");
        $this->assertEquals("http://newurl.com", $this->validBook->getUrl());
    }

    public function testDescriptionCanBeChanged(): void
    {
        $this->validBook->setDescription("New description");
        $this->assertEquals("New description", $this->validBook->getDescription());
    }

    public function testCreatedAtIsSet(): void
    {
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->validBook->getCreatedAt());
    }
    
    public function testUpdatedAtIsSet(): void
    {
        $this->assertInstanceOf(\DateTimeImmutable::class, $this->validBook->getUpdatedAt());
    }
    
    public function testToArray(): void
    {
        $expectedArray = [
            'title' => "Book Title",
            'subtitle' => "Book Subtitle",
            'author' => "Author Name",
            'year' => 2023,
            'category' => "Architecture",
            'language' => "en",
            'country' => "France",
            'pages' => 200,
            'price' => 19.95,
            'link' => "https://example.com",
            'status' => "Available",
            'isbn' => "978-3-16-148410-0",
            'url' => "https://example.com/book.jpg",
            'description' => "A book description.",
            'createdAt' => $this->validBook->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $this->validBook->getUpdatedAt()->format('Y-m-d H:i:s')
        ];
    
        $actualArray = $this->validBook->__toArray();
    
        $this->assertIsArray($actualArray);
    
        $actualArray['createdAt'] = $actualArray['createdAt']->format('Y-m-d H:i:s');
        $actualArray['updatedAt'] = $actualArray['updatedAt']->format('Y-m-d H:i:s');
    
        $this->assertEquals($expectedArray, $actualArray);
    
        $this->assertTrue(true);
    }
}
