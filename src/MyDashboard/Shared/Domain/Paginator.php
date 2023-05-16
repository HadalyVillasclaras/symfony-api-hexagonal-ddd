<?php

namespace App\MyDashboard\Shared\Domain;

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
        $this->calculatePageNumbers();
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

    private function calculatePageNumbers(): void
    {
        $this->pageNumbers["currentPage"] = $this->currentPage;

        if ($this->currentPage > 1) {
            $this->pageNumbers["first"] = 1;
            $this->pageNumbers["prev"] = $this->currentPage - 1;
        }

        if ($this->currentPage + 1 <= $this->totalPages) {
            $this->pageNumbers["next"] = $this->currentPage + 1;
            $this->pageNumbers["last"] = $this->totalPages;
        }
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

    public function getLinks(UrlGeneratorInterface $router, string $routeName, array $urlQueryParams, ?int $linksAbsolutePath = 0): array
    {
        $links = [];

        foreach ($this->pageNumbers as $linkName => $pageNumber) {
            $urlQueryParams = $pageNumber;
            $links[$linkName] = $router->generate($routeName, $urlQueryParams, $linksAbsolutePath);
        }

        return $links;
    }
}
