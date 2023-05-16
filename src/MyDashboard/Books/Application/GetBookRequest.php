<?php

namespace App\MyDashboard\Books\Application;

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