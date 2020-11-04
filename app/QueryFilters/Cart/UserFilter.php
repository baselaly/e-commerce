<?php

namespace App\QueryFilters\Cart;

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

        return $builder->where('user_id', $this->filters['user_id']);
    }
}
