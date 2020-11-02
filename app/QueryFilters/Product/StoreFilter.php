<?php

namespace App\QueryFilters\Product;

use Closure;

class StoreFilter
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function handle($request, Closure $next)
    {
        $builder = $next($request);

        if (!array_key_exists('store_id', $this->filters)) {
            return $builder;
        }

        $filters = $this->filters;

        return $builder->where(function ($query) use ($filters) {
            $query->whereHas('store', function ($query) use ($filters) {
                $query->where('id', $filters['store_id']);
            });
        });
    }
}
