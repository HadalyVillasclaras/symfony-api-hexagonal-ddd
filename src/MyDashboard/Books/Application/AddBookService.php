<?php

namespace App\MyDashboard\Books\Application;

use App\MyDashboard\Books\Domain\Book;
use App\MyDashboard\Books\Domain\BookRepositoryInterface;
use App\MyDashboard\Shared\ValueObjects\BookCategory;
use App\MyDashboard\Shared\ValueObjects\Country;
use App\MyDashboard\Shared\ValueObjects\Language;
use App\MyDashboard\Shared\ValueObjects\Price;

class AddBookService
{
  protected $bookRepository;

  public function __construct(BookRepositoryInterface $bookRepository)
  {
    $this->bookRepository = $bookRepository;
  }

  public function execute(AddBookRequest $addBookRequest)
  {
    $book = new Book(
      $addBookRequest->getTitle(),
      $addBookRequest->getSubtitle(),
      $addBookRequest->getAuthor(),
      $addBookRequest->getYear(),
      new BookCategory($addBookRequest->getCategory()),
      new Language($addBookRequest->getLanguage()),
      new Country($addBookRequest->getCountry()),
      $addBookRequest->getPages(),
      new Price($addBookRequest->getPrice()),
      $addBookRequest->getLink(),
      $addBookRequest->getStatus(),
      $addBookRequest->getIsbn(),
      $addBookRequest->getUrl(),
      $addBookRequest->getDescription()
    );

    $this->bookRepository->save($book);

    return $book;
  }
}
