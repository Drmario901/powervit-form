<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'success' => false,
        'status' => 401,
        'code' => 'UNAUTHORIZED',
        'message' => 'Unauthorized.',
    ], 401);
});

Route::get('/preview/contact-email', [ContactController::class, 'previewEmail'])
    ->name('preview.contact-email');
