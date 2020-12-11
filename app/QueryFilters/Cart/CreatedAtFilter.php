<?php

namespace App\QueryFilters\Cart;

use Closure;

class CreatedAtFilter
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function handle($request, Closure $next)
    {
        $builder = $next($request);

        if (!array_key_exists('created_at', $this->filters)) {
            return $builder;
        }

        return $builder->whereDate('created_at', $this->filters['created_at']['operator'],$this->filters['created_at']['value']);
    }
}
