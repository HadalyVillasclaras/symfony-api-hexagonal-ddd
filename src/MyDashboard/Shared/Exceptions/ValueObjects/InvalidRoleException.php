<?php

namespace App\MyDashboard\Shared\Exceptions\ValueObjects;

use App\MyDashboard\Shared\Domain\Dictionaries\ErrorCodes;

class InvalidRoleException extends \Exception
{
    public function __construct()
    {
        parent::__construct(ErrorCodes::getMessage(2006), 2006);
    }
}
