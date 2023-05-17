<?php

namespace App\MyDashboard\Shared\Exceptions;

use Exception;

class ErrorCodes
{
    private static $errorCodes = [
        1 => '{name} is required',
        2 => '{name} must be type {type}',
        3 => '{name} must be greater than {min_value}',
    ];

    public static function getError(int $errorCode)
    {
        if (!isset(self::$errorCodes[$errorCode])) {
            throw new Exception('Error code not exist');
        }

        return self::$errorCodes[$errorCode];
    }
}
