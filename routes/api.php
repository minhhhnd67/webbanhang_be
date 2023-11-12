<?php

use App\Http\Controllers\Api\Manager\StoreController;
use App\Http\Controllers\Api\Manager\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Google Sign In
Route::post('/get-google-sign-in-url', [\App\Http\Controllers\Api\GoogleController::class, 'getGoogleSignInUrl']);
Route::get('/callback', [\App\Http\Controllers\Api\GoogleController::class, 'loginCallback']);

Route::post('register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('me', [\App\Http\Controllers\Api\AuthController::class, 'me']);
    Route::post('logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);

    Route::post('upload-image', [\App\Http\Controllers\Api\MediaController::class, 'uploadImage']);

    Route::group([
        'prefix' => 'store'
    ], function() {
        Route::get('', [\App\Http\Controllers\Api\Manager\StoreController::class, 'index']);
        Route::post('create', [\App\Http\Controllers\Api\Manager\StoreController::class, 'store']);
        Route::get('{id}/show', [\App\Http\Controllers\Api\Manager\StoreController::class, 'show']);
        Route::post('{id}/update', [\App\Http\Controllers\Api\Manager\StoreController::class, 'update']);
        Route::post('{id}/delete', [\App\Http\Controllers\Api\Manager\StoreController::class, 'destroy']);
    });

    Route::group([
        'prefix' => 'user'
    ], function () {
        Route::get('', [\App\Http\Controllers\Api\Manager\UserController::class, 'index']);
        Route::post('create', [\App\Http\Controllers\Api\Manager\UserController::class, 'store']);
        Route::get('{id}/show', [\App\Http\Controllers\Api\Manager\UserController::class, 'show']);
        Route::post('{id}/update', [\App\Http\Controllers\Api\Manager\UserController::class, 'update']);
        Route::post('{id}/delete', [\App\Http\Controllers\Api\Manager\UserController::class, 'destroy']);
    });

    Route::group([
        'prefix' => 'category'
    ], function () {
        Route::get('', [\App\Http\Controllers\Api\Manager\CategoryController::class, 'index']);
        Route::post('create', [\App\Http\Controllers\Api\Manager\CategoryController::class, 'store']);
        Route::get('{id}/show', [\App\Http\Controllers\Api\Manager\CategoryController::class, 'show']);
        Route::post('{id}/update', [\App\Http\Controllers\Api\Manager\CategoryController::class, 'update']);
        Route::post('{id}/delete', [\App\Http\Controllers\Api\Manager\CategoryController::class, 'destroy']);
    });
});


