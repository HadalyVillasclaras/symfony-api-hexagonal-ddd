<?php

namespace App\MyDashboard\Books\Application;

use App\MyDashboard\Books\Domain\BookRepositoryInterface;

class DeleteBookService 
{
  protected $bookRepository;

  public function __construct(BookRepositoryInterface $bookRepository)
  {
      $this->bookRepository = $bookRepository;
  }

  public function execute(DeleteBookRequest $deleteBookRequest)
  {
    $book = $this->bookRepository->findOneBy(['id' => $deleteBookRequest->getId()]);
    
    // if ($book == null) {
    //   throw new BookNotFoundException();
    // }

    $this->bookRepository->delete($book);
    return $book;
  }
  
}