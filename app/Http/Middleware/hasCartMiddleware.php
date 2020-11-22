<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Resources\Response\ErrorResponse;

class hasCartMiddleware
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
        if (auth()->user()->carts->count() > 0) {
            return $next($request);
        }
        return response()->json(new ErrorResponse('No items in your cart'), 403);
    }
}
