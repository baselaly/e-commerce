<?php

namespace App\QueryFilters\Review;

use Closure;

class ReviewableIdFilter
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function handle($request, Closure $next)
    {
        $builder = $next($request);

        if (!array_key_exists('reviewable_id', $this->filters)) {
            return $builder;
        }

        return $builder->where('reviewable_id', $this->filters['reviewable_id']);
    }
}
