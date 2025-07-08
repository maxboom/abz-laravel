<?php

use App\Http\Middleware\VerifyRegistrationToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\{
    TokenController,
    UserController,
    PositionController
};

Route::prefix('v1')->group(function () {
    Route::post('/token', [TokenController::class, 'generate']);

    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store'])->middleware(VerifyRegistrationToken::class);
    Route::get('/users/{id}', [UserController::class, 'show']);

    Route::get('/positions', [PositionController::class, 'index']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
