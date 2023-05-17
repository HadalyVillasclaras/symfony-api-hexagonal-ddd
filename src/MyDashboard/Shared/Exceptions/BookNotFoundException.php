<?php

namespace App\MyDashboard\Shared\Exceptions;

use App\MyDashboard\Shared\Exceptions;

class BookNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct(ErrorCodes::getMessage(1001), 1001);
    }
}
