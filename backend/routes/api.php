<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\BlogSubscribersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PostsController;
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

        Route::resource('blogs', BlogsController::class)->except(['create', 'edit']);
        Route::group(['prefix' => 'blogs', 'as' => 'blogs.'], function () {
            Route::get('/{blog}/restore', [BlogsController::class, 'restore'])->name('restore');
            Route::get('/{blog}/subscribe', [BlogSubscribersController::class, 'subscribe'])->name('subscribe');
            Route::get('/{blog}/unsubscribe', [BlogSubscribersController::class, 'unsubscribe'])->name('unsubscribe');
        });

        Route::resource('posts',  PostsController::class)
            ->only(['index', 'store', 'update', 'destroy']);

        Route::group(['prefix' => 'posts/{post}/comments', 'as' => 'comments'], function () {
            Route::get('/', [CommentsController::class, 'index'])->name('index');
            Route::post('/', [CommentsController::class, 'store'])->name('index');
        });

        Route::get('users/{user_id}/posts', [PostsController::class, 'getUserPosts'])->name('posts.user-posts');

        Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
            Route::get('/', [CategoriesController::class, 'index'])->name('index');
        });
    });
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
