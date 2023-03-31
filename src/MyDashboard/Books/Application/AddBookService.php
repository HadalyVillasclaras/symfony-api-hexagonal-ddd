<?php

  namespace App\MyDashboard\Books\Application;

use App\MyDashboard\Books\Domain\Book;
use App\MyDashboard\Books\Domain\BookRepositoryInterface;
use DateTime;

  class AddBookService
  {
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function execute(AddBookRequest $addBookRequest)
    {
      $date = new \DateTime($addBookRequest->getYear());
      $book = new Book(
        $addBookRequest->getTitle(),
        $addBookRequest->getSubtitle(),
        $addBookRequest->getAuthor(),
        $date,
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
