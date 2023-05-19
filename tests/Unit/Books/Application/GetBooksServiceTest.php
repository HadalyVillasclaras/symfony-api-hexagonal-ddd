<?php

declare(strict_types=1);

namespace App\Tests\Unit\MyDashboard\books\Application;

use App\MyDashboard\books\Application\book\GetbooksRequest;
use App\MyDashboard\books\Application\book\GetbooksService;
use App\MyDashboard\books\Infrastructure\InMemoryBookRepository;
use App\MyDashboard\Shared\Domain\SearchCriteria\UrlQueryStringToCriteriaConverter;
use PHPUnit\Framework\TestCase;

final class GetbooksServiceTest extends TestCase
{
    private InMemoryBookRepository $bookRepository;

    public function setUp(): void
    {
        $this->bookRepository = new InMemoryBookRepository();
    }

    public function testValidGetbooksServiceWithFilters()
    {
        $urlQueryParams = [
            "filter" => [
                //"bookTexts.language::eq::de",
            ],
            "sort" => "-id"
        ];

        $urlQueryString = http_build_query($urlQueryParams);
        $criteria = (new UrlQueryStringToCriteriaConverter($urlQueryString))->convert();

        $getbooksRequest = new GetbooksRequest($criteria);
        $getbooksService = new GetbooksService($this->bookRepository);
        $bookserviceResponse = $getbooksService->execute($getbooksRequest);

        $this->assertEquals(22, $bookserviceResponse[0]->getId());
    }

    public function testValidGetbooksServiceWithoutFilters()
    {
        $urlQueryParams = [];

        $urlQueryString = http_build_query($urlQueryParams);
        $criteria = (new UrlQueryStringToCriteriaConverter($urlQueryString))->convert();

        $getbooksRequest = new GetbooksRequest($criteria);
        $getbooksService = new GetbooksService($this->bookRepository);
        $bookserviceResponse = $getbooksService->execute($getbooksRequest);

        $this->assertIsArray($bookserviceResponse);
        $this->assertNotEmpty($bookserviceResponse);
    }
}
