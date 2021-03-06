<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\Dialog\DialogController;
use App\Http\Controllers\Api\Dialog\DialogMessageController;
use App\Http\Controllers\Api\FriendController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PrivacySettingController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ViewController;
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
        Route::get('', [UserController::class, 'index']);
        Route::get('me', [UserController::class, 'getMe']);
        Route::get('{user}', [UserController::class, 'show']);

        Route::put('{user}', [UserController::class, 'update']);
        Route::post('{user}/avatar', [UserController::class, 'updateAvatar']);
    });

    Route::group(['prefix' => 'privacy-settings'], function () {
        Route::put('{privacySetting}', [PrivacySettingController::class, 'update']);
    });

    Route::group(['prefix' => 'friends'], function () {
        Route::get('my', [FriendController::class, 'getMyFriends']);
        Route::get('{user}', [FriendController::class, 'getFriends']);

        Route::post('{user}', [FriendController::class, 'store']);
    });

    Route::group(['prefix' => 'posts'], function () {
        Route::get('', [PostController::class, 'index']);
        Route::get('{post}', [PostController::class, 'show']);

        Route::post('', [PostController::class, 'store'])
            ->middleware(['throttle:createPost']);

        Route::put('{post}', [PostController::class, 'update'])
            ->middleware(['throttle:updatePost']);

        Route::delete('{post}', [PostController::class, 'destroy']);
    });

    Route::group(['prefix' => 'views'], function () {
        Route::post('', [ViewController::class, 'store']);
    });

    Route::group(['prefix' => 'likes'], function () {
        Route::post('', [LikeController::class, 'store']);

        Route::delete('', [LikeController::class, 'delete']);
    });

    Route::group(['prefix' => 'comments'], function () {
        Route::get('', [CommentController::class, 'index']);
        Route::get('{comment}', [CommentController::class, 'show']);

        Route::post('', [CommentController::class, 'store']);

        Route::put('{comment}', [CommentController::class, 'update']);

        Route::delete('', [CommentController::class, 'delete']);
    });

    Route::group(['prefix' => 'dialogs'], function () {
        Route::get('', [DialogController::class, 'index']);
        Route::post('', [DialogController::class, 'store']);
        Route::delete('{dialog}', [DialogController::class, 'delete']);

        Route::group(['prefix' => '{dialog}/messages'], function () {
            Route::get('', [DialogMessageController::class, 'index']);
            Route::post('', [DialogMessageController::class, 'store']);
            Route::post('{dialogMessage}/read', [DialogMessageController::class, 'markAsRead']);
        });
    });
});
