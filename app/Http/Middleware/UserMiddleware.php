<?php

namespace App\Http\Middleware;

use App\Http\Resources\Response\ErrorResponse;
use Closure;
use Illuminate\Http\Request;

class UserMiddleware
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
        if (!$user = auth()->user()) {
            return response()->json(new ErrorResponse('Not Authenticated'), 401);
        }

        if (!$user->active || !$user->verified) {
            return response()->json(new ErrorResponse('Not Authenticated'), 401);
        }

        return $next($request);
    }
}
