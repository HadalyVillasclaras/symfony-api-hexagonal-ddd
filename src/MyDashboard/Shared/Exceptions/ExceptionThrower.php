<?php

namespace App\MyDashboard\Shared\Exceptions;

use Exception;
use App\MyDashboard\Shared\Exceptions;

class ExceptionThrower
{
    public static function emptyValue(string $name, $value)
    {
        if (
            $value === null
            || empty($value)
        ) {
            throw new Exception(
                str_replace('{name}', $name, ErrorCodes::getError(1)),
                1
            );
        }
    }

    public static function emptyNumericValue(string $name, $value, bool $canBe0 = true)
    {
        if ($value === null) {
            throw new Exception(
                str_replace('{name}', $name, ErrorCodes::getError(1)),
                1
            );
        }

        if (is_numeric($value)) {
            if (is_float($value)) {
                $value = floatval($value);
            } else {
                $value = intval($value);
            }
        } else {
            throw new Exception(
                str_replace(['{name}', '{type}'], [$name, 'numeric'], ErrorCodes::getError(2)),
                2
            );
        }

        if (
            !$canBe0
            && (
                $value === 0
                || $value === 0.0
            )
        ) {
            throw new Exception(
                str_replace(['{name}', '{min_value}'], [$name, "0"], ErrorCodes::getError(3)),
                3
            );
        }
    }

    public static function arrayValueIsSet(string $name, $key, array $array)
    {
        if (!array_key_exists($key, $array)) {
            throw new Exception(
                str_replace('{name}', $name, ErrorCodes::getError(1)),
                1
            );
        }

        self::emptyValue($name, $array[$key]);
    }

    public static function arrayNumericValueIsSet(string $name, $key, array $array, bool $canBe0 = true)
    {
        if (!array_key_exists($key, $array)) {
            throw new Exception(
                str_replace('{name}', $name, ErrorCodes::getError(1)),
                1
            );
        }

        self::emptyNumericValue($name, $array[$key], $canBe0);
    }
}
