<?php

namespace App\Ruralidays\Shared\Domain\SearchCriteria;

use Exception;
use InvalidArgumentException;

class Criteria
{
    private FilterGroups $filterGroups;
    private Order $order;
    private ?int $offset;
    private ?int $limit;
    private ?Aggregations $aggregations;

    public function __construct(
        FilterGroups $filterGroups,
        Order $order,
        ?int $offset,
        ?int $limit,
        ?Aggregations $aggregations
    ) {
        $this->filterGroups = $filterGroups;
        $this->order = $order;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->aggregations = $aggregations;
    }

    /**
     * @return FilterGroups
     */
    public function getFilterGroups(): FilterGroups
    {
        return $this->filterGroups;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @return null|int
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @return null|int
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @return null|Aggregations
     */
    public function getAggregations(): ?Aggregations
    {
        return $this->aggregations;
    }
}
