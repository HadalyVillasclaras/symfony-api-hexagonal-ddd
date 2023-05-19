<?php

namespace App\Tests\Unit\MyDashboard\Shared\Utils;

use App\MyDashboard\Shared\Utils\Paginator;
use PHPUnit\Framework\TestCase;

class PaginatorTest extends TestCase
{
    public function testCanGetPaginationData()
    {
        $paginator = new Paginator(100, 10, 1);

        $this->assertSame([
            "dataCount" => 100,
            "dataPerPage" => 10,
            "totalPages" => 10,
            "currentPage" => 1
        ], $paginator->getPaginationData());
    }

    public function testCanGetNextAndPreviousPage()
    {
        $paginator = new Paginator(100, 10, 5);

        $this->assertSame(6, $paginator->getNextPage());
        $this->assertSame(4, $paginator->getPreviousPage());
    }
}
