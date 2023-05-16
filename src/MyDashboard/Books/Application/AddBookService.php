<?php

namespace App\MyDashboard\Books\Application;

use App\MyDashboard\Books\Domain\Book;
use App\MyDashboard\Books\Domain\BookRepositoryInterface;
use App\MyDashboard\Shared\Domain\ValueObject\Language;

class AddBookService
{
  protected $bookRepository;

  public function __construct(BookRepositoryInterface $bookRepository)
  {
    $this->bookRepository = $bookRepository;
  }

  public function execute(AddBookRequest $addBookRequest)
  {

    $language = (!empty($addBookRequest->getLanguage()))
      ? new Language($addBookRequest->getLanguage())
      : null;

    $book = new Book(
      $addBookRequest->getTitle(),
      $addBookRequest->getSubtitle(),
      $addBookRequest->getAuthor(),
      $addBookRequest->getYear(),
      $addBookRequest->getCategory(),
      $language->getLanguage(),
      $addBookRequest->getCountry(),
      $addBookRequest->getPages(),
      $addBookRequest->getPrice(),
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
