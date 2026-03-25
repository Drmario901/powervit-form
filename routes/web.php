<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->view('unauthorized', [], 401);
});

Route::get('/preview/contact-email', [ContactController::class, 'previewEmail'])
    ->name('preview.contact-email');
