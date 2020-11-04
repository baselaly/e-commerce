<?php

namespace App\QueryFilters\Cart;

use Closure;

class ProductFilter
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function handle($request, Closure $next)
    {
        $builder = $next($request);

        if (!array_key_exists('product_id', $this->filters)) {
            return $builder;
        }

        return $builder->where('product_id', $this->filters['product_id']);
    }
}
