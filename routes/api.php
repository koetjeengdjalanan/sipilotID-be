<?php

use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\MainContentController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\TagController;
use App\Libraries\ApiResponse;
use App\Models\MailSubscription;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['api', 'auth:api']], function () {
    Route::get('', [AdminPanelController::class, 'dashboard'])->name('dashboard');
    Route::group(['prefix' => 'control', 'as' => 'control.', 'middleware' => ['role:Super Admin']], function () {
        Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
            Route::get('', [AdminPanelController::class, 'showUser'])->name('index');
            Route::Post('create', [AdminPanelController::class, 'createUser'])->name('create');
            Route::delete('delete', [AdminPanelController::class, 'deleteUser'])->name('delete');
            Route::post('update', [AdminPanelController::class, 'updateUser'])->name('update');
            Route::get('reset-request', [AuthController::class, 'resetRequest'])->name('reset-request');
            Route::post('grant-password-reset', [AuthController::class, 'grantPasswordReset'])->name('grant-password-reset');
            Route::get('deleted', [AdminPanelController::class, 'deletedOnly'])->name('deleted');
            Route::get('restore', [AdminPanelController::class, 'restore'])->name('restore');
        });
        Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
            Route::get('', [AdminPanelController::class, 'roles'])->name('index');
            Route::post('assign', [AdminPanelController::class, 'assignRole'])->name('assign');
        });
    });
    Route::group(['prefix' => 'post', 'as' => 'post.'], function () {
        Route::get('list', [AdminPanelController::class, 'postList'])->name('list');
        Route::post('store', [PostController::class, 'store'])->name('store');
        Route::get('publish', [PostController::class, 'publish'])->name('publish');
        Route::post('edit', [PostController::class, 'edit'])->name('edit');
        Route::group(['prefix' => 'assign', 'as' => 'assign.'], function () {
            Route::post('tags', [TagController::class, 'store'])->name('store');
            Route::post('media', [MediaController::class, 'storePost'])->name('media');
        });
        Route::group(['prefix' => 'delete', 'as' => 'delete.'], function () {
            Route::get('', [PostController::class, 'trashed'])->middleware('role:Super Admin|Admin')->name('index');
            Route::delete('soft', [PostController::class, 'destroy'])->middleware('role:Super Admin|Admin')->name('soft');
            Route::delete('permanent', [PostController::class, 'annihilate'])->middleware('role:Super Admin')->name('annihilate');
            Route::post('restore', [PostController::class, 'restore'])->middleware('role:Super Admin')->name('restore');
        });
    });
    Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
        Route::get('', [CategoryController::class, 'list'])->name('index');
        Route::post('store', [CategoryController::class, 'store'])->name('store');
        Route::delete('delete', [CategoryController::class, 'destroy'])->name('delete');
    });
    Route::group(['prefix' => 'form', 'as' => 'form.', 'middleware' => ['role:Super Admin|Admin']], function () {
        Route::get('', [FormController::class, 'adminIndex'])->name('adminIndex');
        Route::post('publish', [AdminPanelController::class, 'publish'])->name('publish');
        Route::get('submission', [SubmissionController::class, 'index'])->name('index');
        Route::get('answers', [SubmissionController::class, 'show'])->name('answers');
        Route::group(['prefix' => 'assign', 'as' => 'assign.'], function () {
            Route::Post('media', [MediaController::class, 'storeForm'])->name('media');
        });
    });
    Route::group(['prefix' => 'maincontent', 'as' => 'maincontent.', 'middleware' => ['role:Super Admin|Admin']], function () {
        Route::post('update', [MainContentController::class, 'update'])->name('update');
    });
    Route::post('upload', [MediaController::class, 'upload'])->name('upload');
});

Route::group(['prefix' => 'maincontent', 'as' => 'maincontent.'], function () {
    Route::get('', [MainContentController::class, 'index'])->name('index');
});

Route::group(['prefix' => 'event', 'as' => 'event.'], function () {
    Route::get('', [FormController::class, 'index'])->name('index');
    Route::get('upcoming', [FormController::class, 'upcoming'])->name('upcoming');
    Route::get('show', [FormController::class, 'show'])->name('show');
    Route::post('submission', [SubmissionController::class, 'store'])->name('submission');
});

Route::group(['prefix' => 'auth', 'as' => 'auth.', 'middleware' => 'api'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('refresh_token', [AuthController::class, 'refreshToken'])->name('refresh_token');
    Route::get('profile', [AuthController::class, 'user'])->name('profile');
    Route::post('change-password', [AuthController::class, 'changePassword'])->name('change-password');
});

Route::group(['prefix' => 'post', 'as' => 'post.'], function () {
    Route::get('', [PostController::class, 'index'])->name('index');
    Route::get('/random', [PostController::class, 'random'])->name('random');
    Route::get('/search', [PostController::class, 'search'])->name('search');
    Route::get('/{slug}', [PostController::class, 'show'])->name('show');
});

Route::group(['prefix' => 'tag', 'as' => 'tag .'], function () {
    Route::get('', [TagController::class, 'index'])->name('index');
    Route::get('/{slug}', [TagController::class, 'show'])->name('show');
});

Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
    Route::get('', [CategoryController::class, 'index'])->name('index');
    Route::get('/{slug}', [CategoryController::class, 'show'])->name('show');
});

Route::group(['prefix' => 'media', 'as' => 'media.'], function () {
    Route::get('', [MediaController::class, 'index'])->name('index');
    Route::get('show', [MediaController::class, 'show'])->name('show');
});

Route::post('emailSubscription', function () {
    if (request()->filled('mail')) {
        $res = MailSubscription::create([
            'mail' => request()->mail,
        ]);
        return ApiResponse::created('', $res);
    }
    return ApiResponse::forbidden('queryRequired', ['required' => '\'mail\' param in query']);
})->middleware('throttle:0.5,1');

Route::get('request-reset-password', function () {
    $email = request()->email ?? null;
    if (!empty($email)) {
        $user = User::where('email', $email)->firstOrFail();
        $res  = $user->update(['request_password_reset' => true]);
        return ApiResponse::success('', ['message' => 'ask your admin nicely to reopen your account', 'data' => $res]);
    } else {
        return ApiResponse::unprocessableEntity('missing params', ['param' => 'email']);
    }
});
