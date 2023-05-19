<?php

declare(strict_types=1);

namespace App\Tests\Unit\MyDashboard\books\Application;

use App\MyDashboard\books\Application\book\GetBookRequest;
use App\MyDashboard\books\Application\book\Getbookservice;
use App\MyDashboard\books\Domain\Exceptions\BookNotFoundException;
use App\MyDashboard\books\Infrastructure\InMemoryBookRepository;
use PHPUnit\Framework\TestCase;

final class GetbookserviceTest extends TestCase
{
    private InMemoryBookRepository $bookRepository;

    public function setUp(): void
    {
        $this->bookRepository = new InMemoryBookRepository();
    }

    public function testValidGetBook(): void
    {
        $getBookRequest = new GetBookRequest(1);

        $getbookservice = new Getbookservice($this->bookRepository);
        $bookserviceResponse = $getbookservice->execute($getBookRequest);

        $this->assertEquals(1, $bookserviceResponse->getId());
        $this->assertEquals("Feedback MyDashboard", $bookserviceResponse->getbooksurvey()->getFeedbackMyDashboard());
    }

    public function testBookNotFoundOnGet()
    {
        $this->expectException(BookNotFoundException::class);

        $getBookRequest = new GetBookRequest(999);
        $bookserviceResponse = new Getbookservice($this->bookRepository);

        $bookserviceResponse->execute($getBookRequest);
    }
}
