<?php

namespace App\MyDashboard\Books\Application;

use App\MyDashboard\Books\Domain\BookRepositoryInterface;

class GetBookService 
{
  protected $bookRepository;

  public function __construct(BookRepositoryInterface $bookRepository)
  {
      $this->bookRepository = $bookRepository;
  }

  public function execute(GetBookRequest $getBookRequest)
  {
    $book = $this->bookRepository->findOneBy(['id' => $getBookRequest->getId()]);
    
    return $book;
  }
}