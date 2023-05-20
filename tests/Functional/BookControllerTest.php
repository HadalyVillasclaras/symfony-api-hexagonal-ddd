<?php

namespace App\Tests\Controller;

use App\MyDashboard\Books\Application\AddBookRequest;
use App\MyDashboard\Books\Application\AddBookService;
use App\MyDashboard\Books\Domain\Book;
use App\MyDashboard\Books\Domain\BookRepositoryInterface;
use App\MyDashboard\Shared\ValueObjects\BookCategory;
use App\MyDashboard\Shared\ValueObjects\Country;
use App\MyDashboard\Shared\ValueObjects\Language;
use App\MyDashboard\Shared\ValueObjects\Price;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class BookControllerTest extends WebTestCase
{
  protected static $client;
  protected static $entityManager;

  public function setUp(): void
  {
    self::$client = static::createClient();
    self::$entityManager = self::$client->getContainer()
        ->get('doctrine')
        ->getManager();

    $schemaTool = new SchemaTool(self::$entityManager);
    $metadata = self::$entityManager->getMetadataFactory()->getAllMetadata();
    $schemaTool->createSchema($metadata);
  }
}
