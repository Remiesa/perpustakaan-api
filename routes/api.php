<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\registerController;
use Illuminate\Support\Facades\Route;

// --

Route::apiResource('data', Controller::class);

Route::delete('/data/{userId}/{bookId}', [Controller::class, 'deleting']);
Route::get('/genre/{id}', [Controller::class, 'genreSearch']);
Route::get('/dataBook', [Controller::class, 'getBookNormal']);

Route::apiResource('users', registerController::class);