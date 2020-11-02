<?php

namespace App\Http\Middleware;

use App\Http\Resources\Response\ErrorResponse;
use Closure;
use Illuminate\Http\Request;

class StoreMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->store) {
            return response()->json(new ErrorResponse('Not Authorized'), 403);
        }

        return $next($request);
    }
}
