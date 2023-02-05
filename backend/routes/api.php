<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\UsersController;
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

Route::get('/test', function (Request $request) {
    return 'Hello Workd';
})->middleware('auth:sanctum');

Route::group(['as' => 'api.'], function() {
    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
        Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
    });

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

        Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
            Route::get('/profile', [UsersController::class, 'profile'])->name('profile');
            Route::put('/profile', [UsersController::class, 'updateProfile'])->name('update-profile');
        });

        Route::group(['prefix' => 'blogs', 'as' => 'blogs.'], function () {
            Route::get('/', [BlogsController::class, 'index'])->name('index');
            Route::get('/{blog}', [BlogsController::class, 'show'])->name('show');
            Route::post('/', [BlogsController::class, 'store'])->name('store');
            Route::put('/{blog}', [BlogsController::class, 'update'])->name('update');
            Route::delete('/{blog}', [BlogsController::class, 'destroy'])->name('destroy');
            Route::get('/{blog}/restore', [BlogsController::class, 'restore'])->name('restore');
        });
    });
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
