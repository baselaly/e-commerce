<?php

namespace App\QueryFilters\User;

use Closure;

class EmailFilter
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function handle($request, Closure $next)
    {
        $builder = $next($request);

        if (!array_key_exists('email', $this->filters)) {
            return $builder;
        }

        return $builder->where('email', $this->filters['email']);
    }
}
