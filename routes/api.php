<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\FriendController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
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

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', RegisterController::class);
    Route::post('login', LoginController::class);
    Route::post('logout', LogoutController::class)
        ->middleware(['auth:sanctum']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['prefix' => 'users'], function () {
        Route::get('me', [UserController::class, 'getMe']);
        Route::get('{user}', [UserController::class, 'show']);
    });

    Route::group(['prefix' => 'friends'], function () {
        Route::get('my', [FriendController::class, 'getMyFriends']);
        Route::get('{user}', [FriendController::class, 'getFriends']);
    });

    Route::group(['prefix' => 'posts'], function () {
        Route::get('', [PostController::class, 'index']);
    });
});
