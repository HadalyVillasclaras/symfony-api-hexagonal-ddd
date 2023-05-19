<?php

namespace App\Tests\Unit\MyDashboard\Shared\Application;

use App\MyDashboard\Shared\Application\ExceptionThrower;
use PHPUnit\Framework\TestCase;

final class ExceptionThrowerTest extends TestCase
{
    public function testNullVariable()
    {
        $this->expectException("Exception");
        $this->expectExceptionMessageMatches("/^variable is required$/");
        $this->expectExceptionCode(1);

        $variable = null;

        ExceptionThrower::emptyValue("variable", $variable);
    }

    public function testEmptyVariable()
    {
        $this->expectException("Exception");
        $this->expectExceptionMessageMatches("/^variable is required$/");
        $this->expectExceptionCode(1);

        $variable = "";

        ExceptionThrower::emptyValue("variable", $variable);
    }

    public function testVariableIsNotNullAndNotEmptyValue()
    {
        $variable = "hello world!";

        $this->assertNull(ExceptionThrower::emptyValue("variable", $variable));
    }

    public function testNullAndEmptyNumericVariable()
    {
        $this->expectException("Exception");
        $this->expectExceptionMessageMatches("/^variable is required$/");
        $this->expectExceptionCode(1);

        $variable = null;

        ExceptionThrower::emptyNumericValue("variable", $variable);
    }

    public function testNumericVariableMustBeNumericType()
    {
        $this->expectException("Exception");
        $this->expectExceptionMessageMatches("/^variable must be type numeric$/");
        $this->expectExceptionCode(2);

        $variable = "Hello World!";

        ExceptionThrower::emptyNumericValue("variable", $variable);
    }

    public function testCanBeZeroValueInNumericVariable()
    {
        $variable = 0;
        $this->assertNull(ExceptionThrower::emptyNumericValue("variable", $variable));

        $variable = 1.2;
        $this->assertNull(ExceptionThrower::emptyNumericValue("variable", $variable));

        $variable = -10;
        $this->assertNull(ExceptionThrower::emptyNumericValue("variable", $variable));

        $variable = -1.1;
        $this->assertNull(ExceptionThrower::emptyNumericValue("variable", $variable));
    }

    public function testCannotBeZeroIntegerTypeVariable()
    {
        $this->expectException("Exception");
        $this->expectExceptionMessageMatches("/^variable must be greater than 0$/");
        $this->expectExceptionCode(3);

        $variable = 0;

        ExceptionThrower::emptyNumericValue("variable", $variable, false);
    }

    public function testCannotBeZeroFloatTypeVariable()
    {
        $this->expectException("Exception");
        $this->expectExceptionMessageMatches("/^variable must be greater than 0$/");
        $this->expectExceptionCode(3);

        $variable = 0.0;

        ExceptionThrower::emptyNumericValue("variable", $variable, false);
    }

    public function testNumericVariableIsNotNullAndNotEmptyValue()
    {
        $variable = 1;

        $this->assertNull(ExceptionThrower::emptyNumericValue("variable", $variable));
        $this->assertNull(ExceptionThrower::emptyNumericValue("variable", $variable, false));

        $variable = 0.1;
        $this->assertNull(ExceptionThrower::emptyNumericValue("variable", $variable));
        $this->assertNull(ExceptionThrower::emptyNumericValue("variable", $variable, false));
    }

    public function testArrayEmpty()
    {
        $this->expectException("Exception");
        $this->expectExceptionMessageMatches("/^variable\\[hello\\] is required$/");
        $this->expectExceptionCode(1);

        $variable = [];

        ExceptionThrower::arrayValueIsSet("variable[hello]", "hello", $variable);
    }

    public function testArrayKeyNotExist()
    {
        $this->expectException("Exception");
        $this->expectExceptionMessageMatches("/^variable\\[hello\\] is required$/");
        $this->expectExceptionCode(1);

        $variable = ["world" => "hello"];

        ExceptionThrower::arrayValueIsSet("variable[hello]", "hello", $variable);
    }

    public function testArrayhasKeyAndNullValue()
    {
        $this->expectException("Exception");
        $this->expectExceptionMessageMatches("/^variable\\[hello\\] is required$/");
        $this->expectExceptionCode(1);

        $variable = ["hello" => null];

        ExceptionThrower::arrayValueIsSet("variable[hello]", "hello", $variable);
    }

    public function testArrayhasKeyAndEmptyValue()
    {
        $this->expectException("Exception");
        $this->expectExceptionMessageMatches("/^variable\\[hello\\] is required$/");
        $this->expectExceptionCode(1);

        $variable = ["hello" => ""];

        ExceptionThrower::arrayValueIsSet("variable[hello]", "hello", $variable);
    }

    public function testArrayIsNotNullAndEmpty()
    {
        $variable = ["hello" => "world"];

        $this->assertNull(ExceptionThrower::arrayValueIsSet("variable", "hello", $variable));
    }

    public function testNumericArrayValueIsEmpty()
    {
        $this->expectException("Exception");
        $this->expectExceptionMessageMatches("/^variable\\[hello\\] is required$/");
        $this->expectExceptionCode(1);

        $variable = [];

        ExceptionThrower::arrayNumericValueIsSet("variable[hello]", "hello", $variable);
    }

    public function testNumericArrayValueKeyNotExists()
    {
        $this->expectException("Exception");
        $this->expectExceptionMessageMatches("/^variable\\[hello\\] is required$/");
        $this->expectExceptionCode(1);

        $variable = ["world" => 0];

        ExceptionThrower::arrayNumericValueIsSet("variable[hello]", "hello", $variable);
    }

    public function testNumericArrayValueMustBeNumericType()
    {
        $this->expectException("Exception");
        $this->expectExceptionMessageMatches("/^variable\\[hello\\] must be type numeric$/");
        $this->expectExceptionCode(2);

        $variable = ["hello" => "Hello World!"];

        ExceptionThrower::arrayNumericValueIsSet("variable[hello]", "hello", $variable);
    }

    public function testNumericArrayValueCanBeZero()
    {
        $variable = ["hello" => 0];

        $this->assertNull(ExceptionThrower::arrayNumericValueIsSet("variable[hello]", "hello", $variable));
    }

    public function testNumericArrayValueCannotBeZero()
    {
        $this->expectException("Exception");
        $this->expectExceptionMessageMatches("/^variable\\[hello\\] must be greater than 0$/");
        $this->expectExceptionCode(3);

        $variable = ["hello" => 0];

        ExceptionThrower::arrayNumericValueIsSet("variable[hello]", "hello", $variable, false);
    }

    public function testNumericArrayValueIsNotNullAndNotEmpty()
    {
        $variable = ["hello" => 1];

        $this->assertNull(ExceptionThrower::arrayNumericValueIsSet("variable", "hello", $variable));
        $this->assertNull(ExceptionThrower::arrayNumericValueIsSet("variable", "hello", $variable, false));
    }
}
