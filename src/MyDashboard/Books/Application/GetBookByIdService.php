<?php

namespace App\MyDashboard\Books\Application;

use App\MyDashboard\Books\Domain\BookRepositoryInterface;
use Exception;

class GetBookByIdService 
{
  protected $bookRepository;

  public function __construct(BookRepositoryInterface $bookRepository)
  {
      $this->bookRepository = $bookRepository;
  }

  public function execute(GetBookByIdRequest $GetBookByIdRequest)
  {
    $book = $this->bookRepository->findOneBy(['id' => $GetBookByIdRequest->getId()]);

    if ($book === null) {
      throw new Exception("Book not found");
    }
    
    return $book;
  }
}