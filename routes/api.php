<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:api'])->group(function () {

    // --- PUBLIC ROUTES ---
    Route::get('/test-ci', function () {
        return response()->json(['message' => 'CI is working']);
    });
    Route::get('/config-check', function () {
        return response()->json([
            'environment' => app()->environment(),
            'payment_key' => env('PAYMENT_API_KEY', 'KUNCI_TIDAK_DITEMUKAN'),
        ]);
    });
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Book Public
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/{id}', [BookController::class, 'show']);

    // --- PROTECTED ROUTES ---
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        // Book CRUD
        Route::post('/books', [BookController::class, 'store']);
        Route::put('/books/{id}', [BookController::class, 'update']);
        Route::delete('/books/{id}', [BookController::class, 'destroy']);
    });

});
