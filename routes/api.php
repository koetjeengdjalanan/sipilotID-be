<?php

use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainContentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
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

Route::group(['prefix' => 'maincontent', 'as' => 'maincontent.'], function () {
    Route::get('', [MainContentController::class, 'index'])->name('index');
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

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:api'], function () {
    Route::get('', [AdminPanelController::class, 'dashboard'])->name('dashboard');
    Route::get('/formList', [AdminPanelController::class, 'eventForm'])->name('eventForm');
    Route::get('/postList', [AdminPanelController::class, 'postList'])->name('postList');
    Route::group(['prefix' => 'form', 'as' => 'form.'], function () {
        Route::post('/publish', [AdminPanelController::class, 'publish'])->name('publish');
    });
    // Route::get('/form', [AdminPanelController::class, 'form'])->name('form');
});

Route::get('request-reset-password', function () {
    $email = request()->email ?? null;
    if ($email !== null) {
        User::where('email', $email)->firstOrFail();
    }
});
