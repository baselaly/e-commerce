<?php

namespace App\QueryFilters\Product;

use Closure;

class OwnerFilter
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function handle($request, Closure $next)
    {
        $builder = $next($request);

        if (!array_key_exists('owner_id', $this->filters)) {
            return $builder;
        }

        $filters = $this->filters;

        return $builder->where(function ($query) use ($filters) {
            $query->whereHas('user', function ($query) use ($filters) {
                $query->where('id', $filters['owner_id']);
            })->orWhereHas('store', function ($query) use ($filters) {
                $query->where('user_id', $filters['owner_id']);
            });
        });
    }
}
