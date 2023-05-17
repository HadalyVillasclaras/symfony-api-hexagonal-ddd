<?php

namespace App\MyDashboard\Books\Application;

class SearchBooksRequest
{
    private $searchCriteria;
    private int $page;

    public function __construct(array $searchCriteria, int $page)
    {
        $this->searchCriteria = $searchCriteria;
        $this->page = $page;
    }

    public function getSearchCriteria()
    {
        return $this->searchCriteria;
    }

    public function getPage(): int
    {
        return $this->page;
    }
}
