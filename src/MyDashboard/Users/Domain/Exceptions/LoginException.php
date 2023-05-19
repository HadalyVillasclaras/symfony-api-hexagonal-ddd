<?php

namespace App\mydashboard\Users\Domain\Exceptions;

class LoginException extends \Exception
{
    public function __construct($message = '', $code = 0)
    {
        parent::__construct($message, $code);
    }
}
