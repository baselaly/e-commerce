<?php

namespace App\QueryFilters\Review;

use Closure;

class ReviewableTypeFilter
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function handle($request, Closure $next)
    {
        $builder = $next($request);

        if (!array_key_exists('reviewable_type', $this->filters)) {
            return $builder;
        }

        return $builder->where('reviewable_type', $this->filters['reviewable_type']);
    }
}
