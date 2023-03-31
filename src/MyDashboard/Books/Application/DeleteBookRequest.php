<?php

namespace App\MyDashboard\Books\Application;

use App\MyDashboard\Books\Domain\BookRepositoryInterface;

class DeleteBookRequest
{
  private $id;
    
  public function __construct(
      int $id
  ) {
    // ExceptionThrower::emptyValue('id', $id);

      $this->id = $id;
  }

  public function getId(): int
  {
      return $this->id;
  }

}