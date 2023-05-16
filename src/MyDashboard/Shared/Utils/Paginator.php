<?php

namespace App\MyDashboard\Shared\Utils;


use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Paginator
{
    private int $dataCount;
    private int $dataPerPage;
    private int $currentPage;
    private int $totalPages;
    private array $pageNumbers;

    public function __construct(int $dataCount, int $dataPerPage, int $currentPage)
    {
        $this->dataCount = $dataCount;
        $this->dataPerPage = $dataPerPage;
        $this->currentPage = $currentPage;
        $this->totalPages = 0;
        $this->pageNumbers = [];

        $this->setPaginationData();
    }

    private function setPaginationData(): void
    {
        $this->calculateTotalPages();
        $this->adjustCurrentPage();
    }

    public function getPaginationData(): array
    {
        return [
            "dataCount" => $this->dataCount,
            "dataPerPage" => $this->dataPerPage,
            "totalPages" => $this->totalPages,
            "currentPage" => $this->currentPage
        ];
    }

    private function calculateTotalPages(): void
    {
        $this->totalPages = $this->dataPerPage > 0 ? ceil($this->dataCount / $this->dataPerPage) : 0;
    }


    private function adjustCurrentPage(): void
    {
        if ($this->currentPage > $this->totalPages) {
            $this->currentPage = $this->totalPages;
        }

        if ($this->currentPage < 1) {
            $this->currentPage = 1;
        }
    }

    public function getPageNumbers(): array
    {
        return $this->pageNumbers;
    }

    public function getNextPage(): int
    {
        $nextPage = $this->currentPage + 1;
        return $nextPage <= $this->totalPages ? $nextPage : $this->currentPage;
    }

    public function getPreviousPage(): int
    {
        $previousPage = $this->currentPage - 1;
        return $previousPage >= 1 ? $previousPage : $this->currentPage;
    }
}
