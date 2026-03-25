<?php

use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'success' => false,
        'status' => 401,
        'message' => 'Unauthorized.',
    ], 401);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::match(['get', 'put', 'patch', 'delete'], '/contact', [ContactController::class, 'methodNotAllowed']);

Route::post('/contact', [ContactController::class, 'send'])
    ->middleware('throttle:contact');
