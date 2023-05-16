<?php

namespace App\MyDashboard\Shared;

class ApiResponse
{
    private array $data;
    private array $pagination;
    private array $error;

    public function __construct()
    {
        $this->data = [];
        $this->pagination = [];
        $this->error = [];
    }

    public function setData(array $data): ApiResponse
    {
        $this->data = $data;
        return $this;
    }

    public function getData() : array
    {
        return $this->data;
    }

    public function setPagination(string $key, $value): ApiResponse
    {
        $this->pagination[$key] = $value;

        return $this;
    }

    public function getPagination(): array
    {
        return $this->pagination;
    }

    public function getError() : array
    {
        return $this->error;
    }

    public function setError($message, $code): ApiResponse
    {
        $this->error = [
            'erroCode' => $code,
            'erroMessage' => $message,
        ];

        return $this;
    }

    public function getApiResponse() : array
    {
        $apiResponse = [];
        $error = $this->getError();

        if (!empty($error)) {
            $apiResponse['error'] = $error;
        } else {
            $data = $this->getData();
            $pagination = $this->getPagination();
            $apiResponse['pagination'] = $pagination;
            $apiResponse['data'] = $data;


            if (isset($apiResponse['data'][0])) {
                foreach($apiResponse['data'] as $key => $data) {
                    $apiResponse['data'][$key] = $data->__toArray();
                }
            }
        }
        return $apiResponse;
    }
}
