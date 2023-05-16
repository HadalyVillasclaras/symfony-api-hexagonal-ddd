<?php

  namespace App\MyDashboard\Books\Application;

use App\MyDashboard\Books\Domain\Book;
use App\MyDashboard\Books\Domain\BookRepositoryInterface;

  class UpdateBookService
  {
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function execute(UpdateBookRequest $updateBookRequest)
    {
      $book = $this->bookRepository->findOneBy(['id' => $updateBookRequest->getId()]);

      $book->setTitle($updateBookRequest->getTitle());
      $book->setSubtitle($updateBookRequest->getSubtitle());
      $book->setAuthor($updateBookRequest->getAuthor());
      $book->setYear($updateBookRequest->getYear());
      $book->setCategory($updateBookRequest->getCategory());
      $book->setLanguage($updateBookRequest->getLanguage());
      $book->setCountry($updateBookRequest->getCountry());
      $book->setPages($updateBookRequest->getPages());
      $book->setPrice($updateBookRequest->getPrice());
      $book->setLink($updateBookRequest->getLink());
      $book->setStatus($updateBookRequest->getStatus());
      $book->setIsbn($updateBookRequest->getIsbn());
      $book->setUrl($updateBookRequest->getUrl());
      $book->setDescription($updateBookRequest->getDescription());
      
      $this->bookRepository->save($book);

      return $book;
    }

  }
