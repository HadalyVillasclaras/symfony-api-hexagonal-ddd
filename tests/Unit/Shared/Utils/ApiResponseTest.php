<?php

namespace App\Tests\Unit\MyDashboard\Shared\Utils;

use App\MyDashboard\Shared\Utils\ApiResponse;
use PHPUnit\Framework\TestCase;

class ApiResponseTest extends TestCase
{
    public function testCanSetDataAndGetApiResponse()
    {
        $apiResponse = new ApiResponse();

        $apiResponse->setData(['test' => 'data']);
        $response = $apiResponse->getApiResponse();

        $this->assertSame(['test' => 'data'], $response['data']);
    }

    public function testCanSetErrorAndGetApiResponse()
    {
        $apiResponse = new ApiResponse();

        $apiResponse->setError('Test error', 123);
        $response = $apiResponse->getApiResponse();

        $this->assertSame(['erroCode' => 123, 'erroMessage' => 'Test error'], $response['error']);
    }
}
