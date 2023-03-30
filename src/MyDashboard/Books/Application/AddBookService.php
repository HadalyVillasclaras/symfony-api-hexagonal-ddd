<?php

  namespace App\MyDashboard\Books\Application;

use App\MyDashboard\Books\Domain\Book;
use App\MyDashboard\Books\Domain\BookRepositoryInterface;

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
        $addBookRequest->getCategory(),
        $addBookRequest->getLanguage(),
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
