<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Showing;
use App\Models\TemporaryTicket;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ShowingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Showings', [
            'showings' => Showing::currentShowings(),
        ]);
    }

    public function indexEvents()
    {
        return Inertia::render('Showings', [
            'showings' => Showing::currentShowings(true),
            'isEvents' => true,
        ]);
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
     * @param  \App\Models\Showing  $showing
     * @return \Illuminate\Http\Response
     */
    public function show(Showing $showing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Showing  $showing
     * @return \Illuminate\Http\Response
     */
    public function edit(Showing $showing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Showing  $showing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Showing $showing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Showing  $showing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Showing $showing)
    {
        //
    }

    public function seats($idShow){
        if(!isset($idShow) || !is_numeric($idShow)){
            throw new HttpException(400, "Invalid parameters");
        }
        if(!Showing::isShowStillAvailable($idShow)){
            throw new HttpException(423, "The show is no longer available");
        }

        $show = Showing::showWithSeats($idShow);

        return Inertia::render('Seats', [
            'show' => $show,
            'temporaryTickets' => TemporaryTicket::getTemporaryTicketByShow($idShow),
            'sessionCode' => Uuid::uuid1(),
            'movie' => Movie::getMovieByID($show->movie_id)
        ]);
    }
}
