<?php

namespace App\Http\Controllers;

use App\Models\Showing;
use App\Models\TemporaryTicket;
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
        if(!Showing::isNumSeatsCorrect($request->id, $request->seats)){
            throw new HttpException(423, "The seats are not valid");
        }
        if(!Showing::seatsStillAvailable($request->id, $request->seats)){
            throw new HttpException(423, "The seats are no longer available");
        }

        return TemporaryTicket::createTemporaryTickets($request->id, $request->seats, $request->code);

    }
}
