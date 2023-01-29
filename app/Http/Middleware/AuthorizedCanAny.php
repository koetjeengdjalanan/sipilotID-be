<?php

namespace App\Http\Middleware;

use App\Libraries\ApiResponse;
use Closure;
use Illuminate\Http\Request;

class AuthorizedCanAny
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        if (!$request->user()) {
            return ApiResponse::error('general.error.unauthenticated');
        }

        $userPermissions = array_map(function ($e) {
            return $e['name'];
        }, $request->user()->getAllPermissions()->toArray());

        $userPermissionsIntersect = array_intersect($userPermissions, $permissions);

        if (!sizeof($userPermissionsIntersect)) {
            return ApiResponse::error('general.error.unauthorized');
        }

        return $next($request);
    }

}
