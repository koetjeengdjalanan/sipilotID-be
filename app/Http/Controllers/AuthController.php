<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserProfileResource;
use App\Libraries\ApiResponse;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Auth;
use Str;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'resetRequest']]);
    }

    public function login(AuthLoginRequest $request)
    {
        $remember = $request['remember'] ?? false;
        unset($request['remember']);
        if (!$token = auth('api')->attempt($request->toArray())) {
            return ApiResponse::unauthorized('Failed Login', ['tips' => 'Please Check your email and password, else ask your administrator for password reset']);
        }
        $payload = auth()->payload();
        $res     = [
            'access_token' => $token,
            'expire_after' => $payload['exp'],
            'issued_at'    => $payload['iat'],
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
        $payload = auth()->payload();
        $res     = [
            'access_token' => $refreshedToken,
            'expire_after' => $payload['exp'],
            'issued_at'    => $payload['iat'],
        ];
        return ApiResponse::success('Login Success', new LoginResource($res));
    }

    public function user()
    {
        $userId = auth()->user()->id;
        $res    = User::with('media', 'roles')->firstWhere('id', $userId);
        return ApiResponse::success('', new UserProfileResource($res));
    }

    public function resetRequest(User $user)
    {
        $res = $user->whereRequestPasswordReset(true)->get();
        return ApiResponse::success('', $res);
    }

    public function changePassword(ChangePasswordRequest $changePasswordRequest)
    {
        if ($changePasswordRequest->validated()['new_password'] != $changePasswordRequest->validated()['repeat_new_password']) {
            return ApiResponse::unprocessableEntity('', ['error' => 'new password not match']);
        }
        $user           = User::whereUsername(auth()->user()->username)->first();
        $user->password = bcrypt($changePasswordRequest->validated()['new_password']);
        $res            = $user->save();
        return ApiResponse::success('', $res);
    }

    public function grantPasswordReset(User $user)
    {
        $validated = request()->validate([
            'user_id' => 'required|uuid|exists:\App\Models\User,id',
        ]);
        $res                                 = Str::random(8);
        $currentUser                         = $user->whereId($validated['user_id'])->first();
        $currentUser->password               = bcrypt($res);
        $currentUser->request_password_reset = false;
        $currentUser->save();
        return ApiResponse::success('', ['new Password' => $res]);
    }
}
