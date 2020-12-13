<?php

namespace App\QueryFilters\Like;

use Closure;

class LikeableTypeFilter
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function handle($request, Closure $next)
    {
        $builder = $next($request);

        if (!array_key_exists('likeable_type', $this->filters)) {
            return $builder;
        }

        return $builder->where('likeable_type', $this->filters['likeable_type']);
    }
}
