<?php

use Illuminate\Support\Facades\Route;

Route::get('/books', function () {
    return response()->json(['message' => 'List of books']);
});
