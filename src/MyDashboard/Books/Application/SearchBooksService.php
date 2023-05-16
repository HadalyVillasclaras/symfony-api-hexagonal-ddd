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

        $booksResponse = $this->bookRepository->findByCriteria($searchCriteria, 10);

        return $booksResponse;
    }
}
