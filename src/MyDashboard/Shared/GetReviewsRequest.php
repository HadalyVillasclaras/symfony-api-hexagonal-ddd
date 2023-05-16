<?php

declare(strict_types=1);

namespace App\Ruralidays\Reviews\Application\Review;

use App\Ruralidays\Shared\Domain\SearchCriteria\Criteria;

class GetReviewsRequest
{
    private $searchCriteria;

    public function __construct(Criteria $searchCriteria)
    {
        $this->searchCriteria = $searchCriteria;
    }

    public function getSearchCriteria()
    {
        return $this->searchCriteria;
    }
}
