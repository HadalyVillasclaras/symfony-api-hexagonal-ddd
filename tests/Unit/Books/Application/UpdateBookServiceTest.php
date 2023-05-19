<?php

declare(strict_types=1);

namespace App\Tests\Unit\MyDashboard\books\Application;

use App\MyDashboard\books\Application\book\UpdateBookRequest;
use App\MyDashboard\books\Application\book\Updatebookservice;
use App\MyDashboard\books\Domain\Exceptions\BookNotFoundException;
use App\MyDashboard\books\Domain\book;
use App\MyDashboard\books\Domain\booksurvey;
use App\MyDashboard\books\Infrastructure\InMemoryBookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

final class UpdatebookserviceTest extends TestCase
{
    private InMemoryBookRepository $bookRepository;

    public function setUp(): void
    {
        $this->bookRepository = new InMemoryBookRepository();
    }

    public function testValidUpdateBook(): void
    {
        $updateRequestParams = json_decode('{
            "legacyBookingId": 12345,
            "legacyPropertyId": 1681,
            "status": true,
        
            "bookTexts": [
            
            "createdAt": "2022-11-02 09:21:08",
            "updatedAt": "2022-11-02 10:21:08"
        }', true);

        $updateBookRequest = UpdateBookRequest::createFromArray($updateRequestParams, 5);

        $updatebookservice = new Updatebookservice($this->bookRepository);
        $updateBookResponse = $updatebookservice->execute($updateBookRequest);

        $this->assertInstanceOf(book::class, $updateBookResponse);
        $this->assertInstanceOf(booksurvey::class, $updateBookResponse->getbooksurvey());
        $this->assertInstanceOf(ArrayCollection::class, $updateBookResponse->getBookTexts());
    
        $this->assertSame("ES", $updateBookResponse->getCustomerCountry());
        $this->assertSame("es", $updateBookResponse->getCustomerLanguage()->value());
        $this->assertSame("2022-11-02 09:21:08", $updateBookResponse->getCreatedAt()->format("Y-m-d H:i:s"));
        $this->assertSame("2022-11-02 10:21:08", $updateBookResponse->getUpdatedAt()->format("Y-m-d H:i:s"));

        $books = $updateBookResponse->getbooksurvey()->getRatings()->__toArray();
        $this->assertSame(6, count($books));

        $this->assertInstanceOf(ArrayCollection::class, $updateBookResponse->getBookTexts());
        $this->assertInstanceOf(booksurvey::class, $updateBookResponse->getbooksurvey());

        $this->assertSame(
            2,
            $updateBookResponse->getbooksurvey()->getRatings()->__toArray()["2"]["score"]
        );
    }

    public function testBookIdNotFoundOnUpdate()
    {
        $this->expectException(BookNotFoundException::class);
        $updateRequestParams = json_decode('{
            "userId": 7078,
            "isFake": true,
            "customerName": "Pablo",
            "booksurvey":{
                "travelerType": 2
            }
        }', true);

        $updateBookRequest = UpdateBookRequest::createFromArray($updateRequestParams, 222);

        $updatebookservice = new Updatebookservice($this->bookRepository);
        $updatebookservice->execute($updateBookRequest);
    }
}
