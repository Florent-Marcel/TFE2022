<?php

use App\Http\Controllers\TemporaryTicketController;
use App\Http\Controllers\TicketController;
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

Route::get('/seats/{idShow}', function ($idShow) {
    $show = Showing::showWithSeats($idShow);
    return Inertia::render('Seats', [
        'show' => $show,
        'temporaryTickets' => TemporaryTicket::getTemporaryTicketByShow($idShow),
        'sessionCode' => Uuid::uuid1(),
        'movie' => Movie::getMovieByID($show->movie_id)
    ]);
})->middleware(['auth', 'verified'])->name('seats');

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

require __DIR__.'/auth.php';
