<?php

namespace App\MyDashboard\User\Application;

use App\MyDashboard\User\Infrastructure\UserRepository;
use Exception;

class LoginUserService 
{
  protected $userRepository;

  public function __construct(UserRepository $userRepository)
  {
      $this->userRepository = $userRepository;
  }

  public function execute(LoginUserRequest $loginUserRequest)
  {
    $user = $this->userRepository->findOneBy(['email' => $loginUserRequest->getEmail()]);

    if ($user === null) {
      throw new Exception("User not found"); //login exception
    }

    // check if rquest pass and user pass are equal. 

    // jwt
    
    return $user;
  }
}