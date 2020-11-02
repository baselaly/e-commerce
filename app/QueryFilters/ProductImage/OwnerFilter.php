<?php

namespace App\QueryFilters\ProductImage;

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

        return $builder->whereHas('product', function ($query) use ($filters) {
            $query->whereHas('store', function ($query) use ($filters) {
                $query->where('user_id', $filters['owner_id']);
            })->orWhereHas('user', function ($query) use ($filters) {
                $query->where('id', $filters['owner_id']);
            });
        });
    }
}
