<?php

namespace App\QueryFilters\Product;

use Closure;

class ActiveFilter
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function handle($request, Closure $next)
    {
        $builder = $next($request);

        if (!array_key_exists('active', $this->filters)) {
            return $builder;
        }

        return $builder->where('active', $this->filters['active']);
    }
}
