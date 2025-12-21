<?php

use App\Http\Controllers\TomatoController;
use Illuminate\Support\Facades\Route;

Route::post('/analyze', [App\Http\Controllers\TomatoController::class, 'analyze']);
Route::view('/', 'upload');
