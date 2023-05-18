<?php

namespace App\MyDashboard\Books\Application;

use App\MyDashboard\Books\Domain\Book;
use App\MyDashboard\Books\Domain\BookRepositoryInterface;
use App\MyDashboard\Shared\Domain\ValueObject\BookCategory;
use App\MyDashboard\Shared\Domain\ValueObject\Country;
use App\MyDashboard\Shared\Domain\ValueObject\Language;
use App\MyDashboard\Shared\Domain\ValueObject\Price;

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
