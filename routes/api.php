<?php

use Illuminate\Support\Facades\Route;

Route::get('/books', function () {
    return response()->json(['message' => 'List of books']);
});

Route::get('/test-ci', function () {
    return response()->json(['message' => 'CI is working']);
});

Route::get('/config-check', function () {
    return response()->json([
        'environment' => app()->environment(),
        'payment_key' => env('PAYMENT_API_KEY', 'KUNCI_TIDAK_DITEMUKAN'),
    ]);
});
