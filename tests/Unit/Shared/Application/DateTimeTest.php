<?php

namespace App\Tests\Unit\MyDashboard\Shared\Application;

use App\MyDashboard\Shared\Application\DateTimeHelper;
use DateTime;
use PHPUnit\Framework\TestCase;

final class DateTimeTest extends TestCase
{
    public function testConvertTimeZoneFromCestToUtc()
    {
        $date = new DateTimeHelper();

        $this->assertSame($date->convertTimeZoneFromCestToUtc('2022-01-01 10:40', 'string'), '2022-01-01 09:40:00');
        $this->assertSame($date->convertTimeZoneFromCestToUtc('2022-01-01 00:00', 'string'), '2021-12-31 23:00:00');
    }

    public function testConvertTimeZoneFromUtcToCest()
    {
        $date = new DateTimeHelper();

        $this->assertSame($date->convertTimeZoneFromUtcToCest('2022-01-01 09:40', 'string'), '2022-01-01 10:40:00');
        $this->assertSame($date->convertTimeZoneFromUtcToCest('2021-12-31 23:00', 'string'), '2022-01-01 00:00:00');
    }

    public function testConvertDateTimeTimeZoneFromCestToUtc()
    {
        $date = new DateTimeHelper();
        $dateTime = new DateTime("2022-01-01 10:40:10");

        // Default
        $this->assertSame($date->convertDateTimeTimeZoneFromCestToUtc($dateTime), "2022-01-01 09:40:10");

        // Custom
        $dateTimeFormat = "Y/m/d H:i:s";
        $this->assertSame($date->convertDateTimeTimeZoneFromCestToUtc($dateTime, $dateTimeFormat), "2022/01/01 09:40:10");
    }
}
