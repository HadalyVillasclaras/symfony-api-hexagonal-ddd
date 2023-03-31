<?php

namespace App\MyDashboard\Books\Application;

use App\MyDashboard\Books\Domain\BookRepositoryInterface;

class GetBooksService 
{
  protected $bookRepository;

  public function __construct(BookRepositoryInterface $bookRepository)
  {
      $this->bookRepository = $bookRepository;
  }

  public function execute()
  {
    $books = $this->bookRepository->findAll();
    
    return $books;
  }
  
}