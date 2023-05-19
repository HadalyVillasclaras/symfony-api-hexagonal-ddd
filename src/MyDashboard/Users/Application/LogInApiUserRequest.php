<?php

namespace App\mydashboard\Users\Application;

use App\mydashboard\Shared\Domain\ValueObject\Email;

class LogInApiUserRequest
{
    private $email;
    private $password;

    public function __construct(string $email, string $password)
    {
        $this->email = (new Email($email))->value();
        $this->password = $password;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}
