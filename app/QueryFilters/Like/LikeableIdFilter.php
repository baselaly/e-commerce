<?php

namespace App\QueryFilters\Like;

use Closure;

class LikeableIdFilter
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function handle($request, Closure $next)
    {
        $builder = $next($request);

        if (!array_key_exists('likeable_id', $this->filters)) {
            return $builder;
        }

        return $builder->where('likeable_id', $this->filters['likeable_id']);
    }
}
