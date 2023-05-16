<?php

declare(strict_types=1);

namespace App\Ruralidays\Reviews\Application\Review;

class GetReviewsService extends ReviewService
{
    public function execute(GetReviewsRequest $getReviewRequest)
    {
        $searchCriteria = $getReviewRequest->getSearchCriteria();

        $reviews = $this->reviewRepository->findByCriteria($searchCriteria);

        return $reviews;
    }
}
