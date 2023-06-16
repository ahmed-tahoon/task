<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('api')->middleware('auth:sanctum')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::post('posts', [PostController::class, 'store']);
    });
});


Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('admin')->prefix('posts')->group(function () {
        Route::get('unpublished', [PostController::class, 'getUnpublishedPosts']);
    });
});

