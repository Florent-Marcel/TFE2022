<?php

use App\Models\Movie;
use App\Models\Showing;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/movies', function () {
    return Inertia::render('Movies', [
        'movies' => Movie::allWithShowings(),
    ]);
})->middleware(['auth', 'verified'])->name('movies');

Route::get('/showings', function () {
    return Inertia::render('Showings', [
        'showings' => Showing::allWithMovie(),
    ]);
})->middleware(['auth', 'verified'])->name('showings');

Route::get('/test', function () {
    return Inertia::render('PaypalTest', [
    ]);
})->name('test');

require __DIR__.'/auth.php';
