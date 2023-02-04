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

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('', [AdminPanelController::class, 'dashboard'])->name('dashboard');
    Route::group(['prefix' => 'control', 'as' => 'control.'], function () {
        Route::get('user', [AdminPanelController::class, 'showUser'])->name('user');
        Route::Post('user/create', [AdminPanelController::class, 'createUser'])->name('createUser');
        Route::Post('user/permission', [AdminPanelController::class, 'permissionUser'])->name('permission');
        Route::get('role', [AdminPanelController::class, 'roles'])->name('roles');
    });
    Route::group(['prefix' => 'post', 'as' => 'post.'], function () {
        Route::get('list', [AdminPanelController::class, 'postList'])->name('list');
        Route::post('store', [PostController::class, 'store'])->name('store');
        Route::get('publish', [PostController::class, 'publish'])->name('publish');
        Route::post('edit', [PostController::class, 'edit'])->name('edit');
        Route::group(['prefix' => 'assign', 'as' => 'assign.'], function () {
            Route::post('tags', [TagController::class, 'store'])->name('store');
            Route::Post('media', [MediaController::class, 'storePost'])->name('media');
        });
    });
    Route::group(['prefix' => 'form', 'as' => 'form.'], function () {
        Route::get('', [FormController::class, 'adminIndex'])->name('adminIndex');
        Route::post('publish', [AdminPanelController::class, 'publish'])->name('publish');
        Route::get('submission', [SubmissionController::class, 'index'])->name('index');
        Route::get('answers', [SubmissionController::class, 'show'])->name('answers');
        Route::group(['prefix' => 'assign', 'as' => 'assign.'], function () {
            Route::Post('media', [MediaController::class, 'storeForm'])->name('media');
        });
    });
    Route::group(['prefix' => 'maincontent', 'as' => 'maincontent.'], function () {
        Route::post('/update', [MainContentController::class, 'update'])->name('update');
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
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/refresh_token', [AuthController::class, 'refreshToken'])->name('refresh_token');
    Route::get('/profile', [AuthController::class, 'user'])->name('profile');
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
    if ($email !== null) {
        User::where('email', $email)->firstOrFail();
    }
});
