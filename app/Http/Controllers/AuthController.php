<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserProfileResource;
use App\Libraries\ApiResponse;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(AuthLoginRequest $request)
    {
        $remember = $request['remember'] ?? false;
        unset($request['remember']);
        if (!$token = auth('api')->attempt($request->toArray())) {
            return ApiResponse::unauthorized('Failed Login', ['tips' => 'Please Check your email and password, else ask your administrator for password reset']);
        }
        // dd(auth()->ttl);
        $res = [
            'access_token' => $token,
            // 'ttl' => auth()->w
        ];
        return ApiResponse::success('Login Success', new LoginResource(collect($res)));
    }

    public function logout()
    {
        auth()->logout();
        return ApiResponse::success('Logout Success', '');
    }

    public function refreshToken()
    {
        if (!$refreshedToken = auth()->refresh()) {
            ApiResponse::forbidden('', ['tips' => 'Try Re Login']);
        }
        return ApiResponse::success('Login Success', new LoginResource(collect($refreshedToken)));
    }

    public function user()
    {
        $userId = auth()->user()->id;
        $res    = User::with('media')->firstWhere('id', $userId);
        return ApiResponse::success('', new UserProfileResource($res));
    }
}
