<?php

use App\Http\Controllers\ShowingController;
use App\Http\Controllers\TemporaryTicketController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\WebsiteLangController;
use App\Models\Movie;
use App\Models\Paypal;
use App\Models\Showing;
use App\Models\TemporaryTicket;
use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Ramsey\Uuid\Uuid;

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
    return redirect(route('movies'));
    /* return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]); */
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/movies', function () {
    return Inertia::render('Movies', [
        'movies' => Movie::currentMovies(),
    ]);
})->middleware(['auth', 'verified'])->name('movies');

Route::get('/showings', function () {
    return Inertia::render('Showings', [
        'showings' => Showing::currentShowings(),
    ]);
})->middleware(['auth', 'verified'])->name('showings');

Route::get('/events', function () {
    return Inertia::render('Showings', [
        'showings' => Showing::currentShowings(true),
        'isEvents' => true,
    ]);
})->middleware(['auth', 'verified'])->name('events');

Route::get('/seats/{idShow}', [ShowingController::class, 'seats'])
->middleware(['auth', 'verified'])->name('seats');

Route::get('/payment/{code}', function ($code) {
    $controller = new TemporaryTicketController();
    $data = $controller->askPayment($code);
    return Inertia::render('Payment', $data);
})->middleware(['auth', 'verified'])->name('payment');

Route::get('/result/{payment}', function ($payment) {
    $controller = new TicketController();
    $data = $controller->getFromIdCapture($payment);
    return Inertia::render('PaymentResult', $data );
})->middleware(['auth', 'verified'])->name('result.payment');

Route::get('/downloadPDF/{ticket}', function($ticket){
    $controller = new TicketController();
    return $controller->downloadPDF($ticket);
})->middleware(['auth', 'verified'])->name('download.ticket');

Route::get('lang/change/{lang}', function($lang){
    $controller = new WebsiteLangController();
    return $controller->change($lang);
})->name('lang.change');

require __DIR__.'/auth.php';
