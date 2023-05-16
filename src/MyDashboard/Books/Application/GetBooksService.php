<?php

namespace App\MyDashboard\Books\Application;

use App\MyDashboard\Books\Domain\BookRepositoryInterface;

class GetBooksService 
{
  protected $bookRepository;
  private array $bookResponse;

  public function __construct(BookRepositoryInterface $bookRepository)
  {
      $this->bookRepository = $bookRepository;
  }

  public function execute()
  {
    $books = $this->bookRepository->findAll();

    $bookResponse['data'] = $books;
    $bookResponse['pagination'] = [
      'totalFound' => count($bookResponse['data']),
      'dataPerPage' => 10
    ];

    return $bookResponse;
  }
  
}