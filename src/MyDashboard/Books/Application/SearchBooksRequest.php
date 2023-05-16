<?php

namespace App\MyDashboard\Books\Application;

class SearchBooksRequest
{
    private $searchCriteria;

    public function __construct(array $searchCriteria)
    {
        $this->searchCriteria = $searchCriteria;
    }

    public function getSearchCriteria()
    {
        return $this->searchCriteria;
    }
}
