<?php

namespace App\MyDashboard\Shared\Exceptions;

class ErrorCodesDictionary
{
    /**
     * 1000 - 1999 => Book
     *      1000 - 1099 => Book
     *
     *
     */

    private static $errors = [
        "0" => "Error code does not exist",

        "1001" => "Book not found",
        "1002" => "Book already exists",
        "1201" => "Title not found",
        "1202" => "Title already exists",

        "2000" => "The email's format is incorrect",
        "2001" => "The first name's format is incorrect",
        "2002" => "The last name's format is incorrect",
        "2004" => "Invalid language option",
        "2005" => "The phone number's format is incorrect",
        "2006" => "Invalid role option",
       
        "2400" => "Internal server error in legacy",

    ];

    public static function getMessage(int $errorCode = 0)
    {
        if (array_key_exists($errorCode, self::$errors)) {
            return self::$errors[$errorCode];
        } else {
            return self::$errors[0];
        }
    }
}
