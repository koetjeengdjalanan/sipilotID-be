<?php

use App\Http\Controllers\AdminPanelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('', [AdminPanelController::class, 'dashboard'])->name('dashboard');
    Route::group(['prefix' => 'mail', 'as' => 'mail.'], function () {
        Route::get('subscriber', [AdminPanelController::class, 'subscriber'])->name('subscriber');
        Route::get('compose', [AdminPanelController::class, 'compose'])->name('compose');
        Route::get('unSub', [AdminPanelController::class, 'subscriber'])->name('unSub');
    });
    Route::get('destroy', [AdminPanelController::class, 'destroy'])->name('deletePost');
});
