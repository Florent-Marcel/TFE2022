<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ShowingController;
use App\Http\Controllers\TemporaryTicketController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\WebsiteLangController;
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

Route::get('/movies', [MovieController::class, 'index'])
->middleware([])->name('movies');

Route::get('/showings', [ShowingController::class, 'index'])
->middleware([])->name('showings');

Route::get('/events', [ShowingController::class, 'indexEvents'])
->middleware([])->name('events');

Route::get('/seats/{idShow}', [ShowingController::class, 'seats'])
->middleware(['auth', 'verified'])->name('seats');

Route::get('/payment/{code}', [TemporaryTicketController::class, 'askPayment'])
->middleware(['auth', 'verified'])->name('payment');

Route::get('/result/{payment}', [TicketController::class, 'indexFromCaptureId'])
->middleware(['auth', 'verified'])->name('result.payment');

Route::get('/downloadPDF/{ticket}', [TicketController::class, 'downloadPDF'])
->middleware(['auth', 'verified'])->name('download.ticket');

Route::get('lang/change/{lang}', [WebsiteLangController::class, 'change'])
->name('lang.change');

Route::get('profil', [RegisteredUserController::class, 'view'])
->middleware(['auth', 'verified'])->name('profil');

Route::get('profil/delete', [RegisteredUserController::class, 'viewDelete'])
->middleware(['auth', 'verified'])->name('profil.delete');

Route::post('profil/delete', [RegisteredUserController::class, 'delete'])
->middleware(['auth', 'verified']);

Route::get('profil/password/edit', [RegisteredUserController::class, 'viewPasswordEdit'])
->middleware(['auth', 'verified'])->name('profil.password.edit');

Route::post('profil/password/edit', [RegisteredUserController::class, 'passwordEdit'])
->middleware(['auth', 'verified'])->name('profil.password.edit');

require __DIR__.'/auth.php';
