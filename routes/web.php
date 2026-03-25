<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/preview/contact-email', [ContactController::class, 'previewEmail'])
    ->name('preview.contact-email');
