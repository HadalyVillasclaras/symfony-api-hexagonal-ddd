<?php

declare(strict_types=1);

namespace App\Tests\Unit\MyDashboard\books\Application;

use App\MyDashboard\books\Application\book\DeleteBookRequest;
use App\MyDashboard\books\Application\book\Deletebookservice;
use App\MyDashboard\books\Domain\Exceptions\BookNotFoundException;
use App\MyDashboard\books\Infrastructure\InMemoryBookRepository;
use PHPUnit\Framework\TestCase;

final class DeletebookserviceTest extends TestCase
{
    private InMemoryBookRepository $bookRepository;

    public function setUp(): void
    {
        $this->bookRepository = new InMemoryBookRepository();
    }

    public function testValidDeleteBook()
    {
        $bookToDelete = $this->bookRepository->findOneBy(["id" => 5]);

        $deletBookRequest = new DeleteBookRequest($bookToDelete->getId());
        $deletebookserviceResponse = new Deletebookservice($this->bookRepository);

        $deletebookserviceResponse->execute($deletBookRequest);

        $deletedBook = $this->bookRepository->findOneBy(["id" => $bookToDelete->getId()]);

        $this->assertNotSame($bookToDelete, $deletedBook);
        $this->assertNull($deletedBook);
    }

    public function testBookNotFoundOnDelete()
    {
        $this->expectException(BookNotFoundException::class);
        $deletBookRequest = new DeleteBookRequest(999);
        $deletebookserviceResponse = new Deletebookservice($this->bookRepository);

        $deletebookserviceResponse->execute($deletBookRequest);
    }
}
