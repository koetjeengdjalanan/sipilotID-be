<?php

namespace App\Http\Middleware;

use App\Libraries\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthorize
{
    /**
     * guard function
     *
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('api');
    }

    /**
     * handle function
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $appliedMiddleware = $request->route()->gatherMiddleware();
        if (
            $this->hasMiddleware($appliedMiddleware, 'can:') !== true &&
            $this->hasMiddleware($appliedMiddleware, 'canAny:') !== true) {
            return ApiResponse::error('general.error.missing_route_autorization');
        }
        return $next($request);
    }

    /**
     * hasMiddleware function
     *
     * @param  array $appliedMiddleware
     * @param  string $find
     *
     * @return bool
     */
    protected function hasMiddleware(array $appliedMiddleware, string $find): bool
    {
        $found = collect($appliedMiddleware)->filter(function ($value) use ($find) {
            if (strpos($value, $find) !== false) {
                return $value;
            }
        })->count();
        return $found === 0 ? false : true;
    }
}
