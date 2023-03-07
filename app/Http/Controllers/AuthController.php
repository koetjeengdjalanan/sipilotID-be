<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserProfileResource;
use App\Libraries\ApiResponse;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Auth;
use Mail;
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
        Mail::html('<h1 id="maestro-supreme-cms">Maestro Supreme CMS</h1><h3 id="your-password-reset-request-has-been-granted">Your Password Reset Request Has Been Granted</h3><p>This is your new credential:</p><ul><li>Email: ' . $currentUser->email . '</li><li>Password: ' . $res . '</li></ul><hr><blockquote><p>Maestro Supreme Content Management System</p></blockquote>', fn($mail) =>
            $mail->to($currentUser->email)->subject('New Password')
        );
        return ApiResponse::success('', 'Check User Email for Future Instruction');
    }

    public function update(UpdateUserRequest $updateUserRequest, User $user)
    {
        $data = $user->firstWhere('id', auth()->user()->id);
        $req  = collect($updateUserRequest->validated())->except(['id']);
        dd($req);
        $res = $data->updateOrFail($req->toArray());
        return ApiResponse::success($res);
    }
}
