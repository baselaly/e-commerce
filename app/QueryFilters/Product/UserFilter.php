<?php

namespace App\QueryFilters\Product;

use Closure;

class UserFilter
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function handle($request, Closure $next)
    {
        $builder = $next($request);

        if (!array_key_exists('user_id', $this->filters)) {
            return $builder;
        }

        $filters = $this->filters;

        return $builder->where(function ($query) use ($filters) {
            $query->whereHas('user', function ($query) use ($filters) {
                $query->where('id', $filters['user_id']);
            });
        });
    }
}
