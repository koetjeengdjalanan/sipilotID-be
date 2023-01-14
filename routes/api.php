<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainContentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'maincontent', 'as' => 'maincontent.'], function () {
    Route::get('', [MainContentController::class, 'index'])->name('index');
});

Route::group(['prefix' => 'post', 'as' => 'post.'], function () {
    Route::get('', [PostController::class, 'index'])->name('index');
    Route::get('/random', [PostController::class, 'random'])->name('random');
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
