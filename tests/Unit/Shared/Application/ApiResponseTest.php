<?php

namespace App\Tests\Unit\MyDashboard\Shared\Application;

use App\MyDashboard\Shared\Application\ApiResponse;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class ApiResponseTest extends TestCase
{
    public function testOutputSuccessSingleValue()
    {
        $dataArray = [];
        $apiResponse = new ApiResponse();
        $apiResponse->setData($dataArray);
        $output = $apiResponse->getOutput();

        $this->assertArrayHasKey('data', $output, 'Field data not set');
        $this->assertSame($dataArray, $output['data']);
        $this->assertArrayNotHasKey('error', $output, 'Field error is set');
        $this->assertArrayNotHasKey('meta', $output, 'Field meta is set');
        $this->assertArrayNotHasKey('links', $output, 'Field links is set');
    }

    public function testOutputError()
    {
        $dataArray = [1, 2, 3];
        $errorCode = 500;
        $errorMessage = 'Error 500';
        $error = ['code' => $errorCode, 'message' => $errorMessage];
        $apiResponse = new ApiResponse();
        $apiResponse->setData($dataArray);
        $apiResponse->setError($errorMessage, $errorCode);
        $output = $apiResponse->getOutput();

        $this->assertArrayHasKey('error', $output, 'Field error not set');
        $this->assertSame($error, $output['error']);
        $this->assertArrayNotHasKey('data', $output, 'Field data is set');
        $this->assertArrayNotHasKey('meta', $output, 'Field meta is set');
        $this->assertArrayNotHasKey('links', $output, 'Field links is set');
    }

    public function testOutputMeta()
    {
        $testKey = 'testKey';
        $testValue = 'testValue';
        $apiResponse = new ApiResponse();
        $apiResponse->setMeta($testKey, $testValue);
        $output = $apiResponse->getOutput();

        $this->assertArrayHasKey('meta', $output);
        $this->assertArrayNotHasKey('error', $output, 'Field error is set');
    }
}
