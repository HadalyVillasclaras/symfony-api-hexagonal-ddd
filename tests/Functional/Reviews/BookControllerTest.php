<?php

declare(strict_types=1);

namespace App\Tests\Functional\MyDashboard\books;

use App\MyDashboard\Shared\Domain\Dictionaries\ErrorCodes;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class BookControllerTest extends WebTestCase
{
    /**
     * @access private
     * @var array
     */
    private array $headers = [
        'HTTP_X_AUTH_APIKEY' => 'hYVYbShLBsRCQ6gq2aNeP4zckYpZcc',
        'HTTP_ACCEPT' => 'application/json',
        'HTTP_CONTENT_TYPE' => 'application/json',
    ];

    private string $url = '/api/v1/books/';
    private array $bookArray;
    private string $requestBody;

    public function setUp(): void
    {
        $this->client = static::createClient([], $this->headers);

        $container = self::getContainer();
        $this->bookRepository = $container->get('App\MyDashboard\books\Domain\BookRepositoryInterface');

        $this->requestBody = '{
            "legacyBookingId": 12345,
            "legacyPropertyId": 1681,
            "status": true
            "createdAt": "2022-11-02 09:21:08",
            "updatedAt": "2022-11-02 10:21:08"

        }';
        $this->createRequest($this->client, 'POST', $this->url, $this->requestBody);

        $this->bookArray = json_decode($this->client->getResponse()->getContent(), true);
    }

    public function testValidAddBookFunctional(): void
    {
        $data = $this->bookArray['data'];

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);

      
        $this->assertSame(true, $data['status']);
        $this->assertSame(1212, $data['userId']);
        $this->assertSame("2022-11-02T09:21:08+01:00", $data['createdAt']);
        $this->assertSame("2022-11-02T10:21:08+01:00", $data['updatedAt']);
    }

    public function testValidGetBookById(): void
    {
        $urlGetBook = $this->url . $this->bookArray['data']['id'];

        $this->createRequest($this->client, 'GET', $urlGetBook, '');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }

    public function testValidGetbooksListFunctional(): void
    {
        $this->createRequest($this->client, 'GET', $this->url, '');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }

    public function testValidUpdateBookFunctional(): void
    {
        $change = '{ "originalLanguage":"de" }';
        $updateUrl = $this->url . $this->bookArray['data']['id'];

        $this->createRequest($this->client, 'PUT', $updateUrl, $change);

        $bookAsArray = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals($bookAsArray['data']['originalLanguage'], 'de');
    }

    public function testValidDeleteBookFunctional(): void
    {
        $updateUrl = $this->url . $this->bookArray['data']['id'];

        $this->createRequest($this->client, 'DELETE', $updateUrl, '');

        $bookAsArray = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertEquals($bookAsArray['data'], []);
    }

    public function testInvalidAddBookWithoutSurvey(): void
    {
        $requestBodyWithoutSurvey = '{
            "userId": 7078,
            "status": true,
        }';

        $this->createRequest($this->client, 'POST', $this->url, $requestBodyWithoutSurvey);

        $this->bookArray = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseStatusCodeSame(400);

        $this->assertEquals(
            ErrorCodes::getMessage(2203),
            $this->bookArray['error']['message']
        );
    }

    public function testInvalidAddBookRatingsNotValid(): void
    {
        $requestBodyRatingsWrong = '{
            "userId": 707,
            "status": true,
            "originalLanguage": "de",
            "isFake": false,
       
        }';
        $this->bookArray = [];
        $this->createRequest($this->client, 'POST', $this->url, $requestBodyRatingsWrong);
        $this->bookArray = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseStatusCodeSame(400);

        $this->assertEquals(
            ErrorCodes::getMessage(2204),
            $this->bookArray['error']['message']
        );
    }

    public function testInvalidGetInvalidId(): void
    {
        $urlGetBook = $this->url . ($this->bookArray['data']['id'] + 1);

        $this->createRequest($this->client, 'GET', $urlGetBook, '');

        $bookAsArray = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(
            ErrorCodes::getMessage(2201),
            $bookAsArray['error']['message']
        );
    }

    public function testInvalidUpdateBookInvalidId(): void
    {
        $change = '{ "originalLanguage":"de" }';
        $updateUrl = $this->url . ($this->bookArray['data']['id'] + 1);

        $this->createRequest($this->client, 'PUT', $updateUrl, $change);

        $bookAsArray = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(
            ErrorCodes::getMessage(2201),
            $bookAsArray['error']['message']
        );
    }

    public function testInvalidDeleteBookInvalidId(): void
    {
        $updateUrl = $this->url . ($this->bookArray['data']['id'] + 1);

        $this->createRequest($this->client, 'DELETE', $updateUrl, '');

        $bookAsArray = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(
            ErrorCodes::getMessage(2201),
            $bookAsArray['error']['message']
        );
    }

    private function createRequest(KernelBrowser $client, string $method, string $url, string $requestBody): Crawler
    {
        return $client->request(
            $method,
            $url,
            [],
            [],
            [],
            $requestBody
        );
    }
}
