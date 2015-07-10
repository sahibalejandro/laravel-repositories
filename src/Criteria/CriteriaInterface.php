<?php

namespace Sahib\Repositories\Criteria;

interface CriteriaInterface
{
    /**
     * Apply the criteria to a query.
     *
     * @param mixed $query
     */
    public function apply($query);
}