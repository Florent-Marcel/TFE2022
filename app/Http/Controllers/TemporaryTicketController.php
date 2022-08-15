<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Showing;
use App\Models\TemporaryTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TemporaryTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TemporaryTicket  $temporaryTicket
     * @return \Illuminate\Http\Response
     */
    public function show(TemporaryTicket $temporaryTicket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TemporaryTicket  $temporaryTicket
     * @return \Illuminate\Http\Response
     */
    public function edit(TemporaryTicket $temporaryTicket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TemporaryTicket  $temporaryTicket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TemporaryTicket $temporaryTicket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TemporaryTicket  $temporaryTicket
     * @return \Illuminate\Http\Response
     */
    public function destroy(TemporaryTicket $temporaryTicket)
    {
        //
    }

    public function multipleStore(Request $request){
        if(!isset($request->seats, $request->id, $request->code) || !is_numeric($request->id) || !Uuid::isValid($request->code)){
            throw new HttpException(400, "the parameters are incorrect");
        }
        if(!is_array($request->seats)){
            throw new HttpException(400, "seats is not a array");
        }
        if(count($request->seats) == 0 || count($request->seats) > 10){
            throw new HttpException(400, "Number of seat incorrect");
        }
        if(!Showing::isNumSeatsCorrect($request->id, $request->seats)){
            throw new HttpException(423, "The seats are not valid");
        }
        if(!Showing::seatsStillAvailable($request->id, $request->seats)){
            throw new HttpException(423, "The seats are no longer available");
        }

        return TemporaryTicket::createTemporaryTickets($request->id, $request->seats, $request->code);

    }

    public function deleteUserLastTemporaryTickets(Request $request){
        return TemporaryTicket::deleteLastFromUser();
    }

    public function askPayment($code){
        $tempTickets = TemporaryTicket::getTemporaryTicketByCode($code);
        if(count($tempTickets) == 0){
            throw new HttpException(404, "Tickets not found");
        }
        if(auth()->id() != $tempTickets[0]->user_id){
            throw new HttpException(403, "not authorized to access");
        }
        $now = now();
        $tickDate = new Carbon($tempTickets[0]->created_at);
        $tickDate->addMinutes(25);
        $tickDate = $tickDate->timestamp;
        $now = $now->timestamp;
        $time = $now - $tickDate;
        $show = Showing::showWithSeats($tempTickets[0]->showing_id);
        $movie = Movie::getMovieByID($show->movie_id);
        return [
            'show' => $show,
            'temporaryTickets' => $tempTickets,
            'sessionCode' => $code,
            'movie' => $movie,
            'time' => $time,
        ];
    }
}
