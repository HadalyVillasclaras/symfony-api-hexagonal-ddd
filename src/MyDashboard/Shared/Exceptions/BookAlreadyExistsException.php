<?php

namespace App\MyDashboard\Shared\Exceptions;

use App\MyDashboard\Shared\Exceptions\ErrorCodes;

class BookAlreadyExistsException extends \Exception
{
    public function __construct()
    {
        parent::__construct(ErrorCodes::getMessage(1002), 1002);
    }
}
