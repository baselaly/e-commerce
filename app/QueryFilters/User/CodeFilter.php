<?php

namespace App\QueryFilters\User;

use Closure;

class CodeFilter
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function handle($request, Closure $next)
    {
        $builder = $next($request);

        if (!array_key_exists('verify_code', $this->filters)) {
            return $builder;
        }

        return $builder->where('verify_code', $this->filters['verify_code']);
    }
}
