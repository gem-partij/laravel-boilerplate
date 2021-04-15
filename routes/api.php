<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;

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

Route::middleware(['api'])->namespace('Api')->prefix('auth')->group(function () {
    // Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

/**
 * ===============
 * /auth
 * -----
 */
Route::middleware(['auth:api'])->namespace('Api')->prefix('auth')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::get('refresh-token', [AuthController::class, 'refreshToken']);
    Route::get('validate-token', [AuthController::class, 'validateToken']);

    Route::post('update-profile', [AuthController::class, 'updateProfile']);
    Route::post('logout', [AuthController::class, 'logout']);
});
