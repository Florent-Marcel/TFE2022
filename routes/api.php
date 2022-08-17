<?php

use App\Http\Controllers\TemporaryTicketController;
use App\Http\Controllers\TicketController;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware([])->get('/movie/{id}', function (Request $request, $id) {
    return Movie::getMovieByID($id);
});

Route::middleware('auth:sanctum')->post('/createTemporaryTickets', function (Request $request) {
    $temporaryTicketController = new TemporaryTicketController();
    return $temporaryTicketController->multipleStore($request);
});

Route::middleware('auth:sanctum')->post('/deleteUserLastTemporaryTickets', function (Request $request) {
    $temporaryTicketController = new TemporaryTicketController();
    return $temporaryTicketController->deleteUserLastTemporaryTickets($request);
});

Route::middleware('auth:sanctum')->post('/createTickets', function (Request $request) {
    $controller = new TicketController();
    return $controller->multipleStore($request);
});


