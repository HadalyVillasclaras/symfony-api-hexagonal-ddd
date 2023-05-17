<?php

namespace App\MyDashboard\Shared\Exceptions\ValueObjects;

use App\MyDashboard\Shared\Domain\Dictionaries\ErrorCodes;

class InvalidEmailException extends \Exception
{
    public function __construct()
    {
        parent::__construct(ErrorCodes::getMessage(2000), 2000);
    }
}
