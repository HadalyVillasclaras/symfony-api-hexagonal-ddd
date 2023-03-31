<?php

namespace App\MyDashboard\Books\Application;

use App\MyDashboard\Books\Domain\BookRepositoryInterface;

class GetBookRequest
{
  private $id;
    
  public function __construct(
      int $id
  ) {
      $this->id = $id;
  }

  public function getId(): int
  {
      return $this->id;
  }

}