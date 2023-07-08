<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\NewPostController;

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

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('posts', PostController::class);

    Route::get('show', [NewPostController::class, 'index']);
    Route::get('show/{id}', [NewPostController::class, 'show']);
    Route::post('store', [NewPostController::class, 'store']);
    Route::put('update/{id}', [NewPostController::class, 'update']);
    Route::delete('destroy/{id}', [NewPostController::class, 'destroy']);
});
