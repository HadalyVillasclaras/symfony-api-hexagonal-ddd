<?php

  namespace App\MyDashboard\Books\Application;

use App\MyDashboard\Books\Domain\BookRepositoryInterface;
use Exception;

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

      if ($book === null) {
        throw new Exception("Book not found");
      }

      if (
        $updateBookRequest->getTitle() !== null &&
        $updateBookRequest->getTitle() !== ""
      ) {
        $book->setTitle($updateBookRequest->getTitle());
      }

      if (
        $updateBookRequest->getSubtitle() !== null &&
        $updateBookRequest->getSubtitle() !== ""
      ) {
        $book->setSubtitle($updateBookRequest->getSubtitle());
      }

      if (
        $updateBookRequest->getAuthor() !== null &&
        $updateBookRequest->getAuthor() !== ""
      ) {
        $book->setAuthor($updateBookRequest->getAuthor());
      }

      $book->setYear($updateBookRequest->getYear());
      $book->setCategory($updateBookRequest->getCategory());

      if (
        $updateBookRequest->getLanguage() !== null &&
        $updateBookRequest->getLanguage() !== ""
      ) {
        $book->setLanguage($updateBookRequest->getLanguage());
      }

      $book->setCountry($updateBookRequest->getCountry());

      if (
        $updateBookRequest->getPages() !== null &&
        $updateBookRequest->getPages() !== ""
      ) {
        $book->setPages($updateBookRequest->getPages());
      }

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
