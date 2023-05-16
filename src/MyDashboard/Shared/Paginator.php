<?php

namespace App\Ruralidays\Shared\Application;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Paginator
{
    private int $count;
    private int $countPerPage;
    private int $currentPage;
    private int $totalPages;
    private array $pageNumbers;

    public function __construct(int $count, int $countPerPage, int $currentPage)
    {
        $this->count = $count;
        $this->countPerPage = $countPerPage;
        $this->currentPage = $currentPage;
        $this->totalPages = 0;
        $this->pageNumbers = [];

        $this->setData();
    }

    private function setData(): void
    {
        if ($this->countPerPage > 0) {
            $this->totalPages = ceil($this->count / $this->countPerPage);
        }

        if ($this->currentPage > $this->totalPages) {
            $this->currentPage = $this->totalPages;
        }

        if ($this->currentPage < 1) {
            $this->currentPage = 1;
        }

        $this->pageNumbers["self"] = $this->currentPage;

        if ($this->currentPage > 1) {
            $this->pageNumbers["first"] = 1;
            $this->pageNumbers["prev"] = $this->currentPage - 1;
        }

        if ($this->currentPage + 1 <= $this->totalPages) {
            $this->pageNumbers["next"] = $this->currentPage + 1;
            $this->pageNumbers["last"] = $this->totalPages;
        }
    }

    public function getMeta(): array
    {
        return [
            "count" => $this->count,
            "countPerPage" => $this->countPerPage,
            "totalPages" => $this->totalPages,
            "currentPage" => $this->currentPage
        ];
    }

    public function getPageNumbers(): array
    {
        return $this->pageNumbers;
    }

    public function getLinks(UrlGeneratorInterface $router, string $routeName, array $urlQueryParams, ?int $linksAbsolutePath = 0): array
    {
        $links = [];

        foreach ($this->pageNumbers as $linkName => $pageNumber) {
            $urlQueryParams["page"] = $pageNumber;
            $links[$linkName] = $router->generate($routeName, $urlQueryParams, $linksAbsolutePath);
        }

        return $links;
    }
}
