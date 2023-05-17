<?php

namespace App\MyDashboard\Books\Application;

use App\MyDashboard\Books\Domain\BookRepositoryInterface;

class SearchBooksService
{
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function execute(SearchBooksRequest $searchBooksRequest)
    {
        $searchCriteria = $searchBooksRequest->getSearchCriteria();
        $page = $searchBooksRequest->getPage();
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $booksResponse = $this->bookRepository->findByCriteria($searchCriteria, $limit, $offset);

        return $booksResponse;
    }
}
