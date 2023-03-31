<?php

namespace App\Ruralidays\Shared\Application;

class ApiResponse
{
    private array $data;
    private array $error;
    private array $meta;
    private array $links;

    public function __construct()
    {
        $this->data = [];
        $this->error = [];
        $this->links = [];
        $this->meta = [];
    }

    public function setData(array $data) : ApiResponse
    {
        $this->data = $data;
        return $this;
    }

    public function getData() : array
    {
        return $this->data;
    }

    public function getError() : array
    {
        return $this->error;
    }

    public function setError($message, $code) : ApiResponse
    {
        $this->error = [
            'code' => $code,
            'message' => $message,
        ];

        return $this;
    }

    public function setMeta(string $key, $value) : ApiResponse
    {
        $this->meta[$key] = $value;

        return $this;
    }

    public function getMeta(): array
    {
        return $this->meta;
    }

    public function getLinks()
    {
        return $this->links;
    }

    public function setLinks(array $links) : ApiResponse
    {
        $this->links = $links;
        return $this;
    }

    public function setLink(string $key, $value) : ApiResponse
    {
        $this->links[$key] = $value;
        return $this;
    }

    public function getOutput() : array
    {
        $output = [];

        $error = $this->getError();

        if (!empty($error)) {
            $output['error'] = $error;
        } else {
            $meta = $this->getMeta();
            if (!empty($meta)) {
                $output['meta'] = $meta;
            }

            $links = $this->getLinks();
            if (!empty($links)) {
                $output['links'] = $links;
            }

            $data = $this->getData();
            $output['data'] = $data;

            if (isset($output['data'][0])) {
                foreach($output['data'] as $k => $data) {
                    $output['data'][$k] = $data->__toArray();
                }
            }
        }
        return $output;
    }
}
