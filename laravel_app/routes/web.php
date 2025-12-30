<?php

use App\Http\Controllers\TomatoController;
use App\Http\Controllers\TomatoDiseaseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Home Page
Route::get('/', function () {
    return view('home');
})->name('home');

// 2. Upload/Analyze Page
Route::get('/upload', function () {
    return view('upload');
})->name('upload');

Route::post('/analyze', [TomatoController::class, 'analyze'])->name('analyze');

// 2.1 Tomato Disease Diagnosis Page
Route::get('/tomato/diagnose', function () {
    return view('tomato_disease');
})->name('tomato.diagnose.page');

Route::post('/tomato/diagnose', [TomatoDiseaseController::class, 'diagnose'])->name('tomato.diagnose');

// 3. Search Route (For the navbar search)
Route::get('/search', function () {
    $query = request('query');
    // Add your search logic here
    return view('home')->with('searchQuery', $query);
})->name('search');

// 4. Login & Dashboard (Basic routes - customize as needed)
Route::get('/login', function () {
    return redirect('/upload');
})->name('login');

Route::get('/dashboard', function () {
    return view('home');
})->name('dashboard');