<?php

namespace App\mydashboard\Users\Application;

use App\mydashboard\Users\Domain\ApiUser;
use App\mydashboard\Users\Domain\Employee;
use Symfony\Component\Security\Core\User\UserInterface;

class LogInApiUserResponse
{
    private UserInterface $user;
    private $token;
    private $expire;

    public function __construct(UserInterface $user, string $token, int $expire)
    {
        $this->user = $user;
        $this->token = $token;
        $this->expire = $expire;
    }

    public function user(): UserInterface
    {
        return $this->user;
    }

    public function token(): string
    {
        return $this->token;
    }

    public function expire(): int
    {
        return $this->expire;
    }
}
