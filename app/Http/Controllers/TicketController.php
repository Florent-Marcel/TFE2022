<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Paypal;
use App\Models\Showing;
use App\Models\TemporaryTicket;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\HttpException;
use PDF;
use QrCode;

class TicketController extends Controller
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
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    /**
     * Create the tickets
     */
    public function multipleStore($request){
        if(!isset($request->codeTempTicket, $request->idCapturePaypal)){
            throw new HttpException(400, "the parameters are incorrect");
        }
        $tickets = TemporaryTicket::getTemporaryTicketByCode($request->codeTempTicket);
        if(!$tickets || count($tickets) == 0) {
            throw new HttpException(423, "no temporary tickets");
        }

        $payment = Paypal::getcapture($request->idCapturePaypal);
        if(!$payment){
            throw new HttpException(423, "no paypal transaction");
        }

        if($payment->status != "COMPLETED"){
            throw new HttpException(423, "Payment not completed");
        }

        if(!TemporaryTicket::checkPayment($tickets, $payment)){
            throw new HttpException(400, "Payment incorrect");
        }

        foreach($tickets as $ticket){
            $res = Ticket::createTicket($ticket->showing_id, $ticket->num_seat, $request->idCapturePaypal);
            if(!$res){
                throw new HttpException(400, "Error creating ticket");
            }
            $ticket->delete();
        }
        return $res;
    }

    /**
     * Show the result of the payment
     * @param captureId The paypal capture ID
     */
    public function indexFromCaptureId($captureId){
        $tickets = Ticket::getByIdCapture($captureId);
        if(!$tickets || count($tickets) == 0) {
            throw new HttpException(423, "No tickets");
        }
        if($tickets[0]->user_id != auth()->id()) {
            throw new HttpException(403, "You cannot see these tickets");
        }
        $show = Showing::showWithSeats($tickets[0]->showing_id);
        $movie = Movie::getMovieByID($show->movie_id);
        $data = [
            'show' => $show,
            'tickets' => $tickets,
            'movie' => $movie,
        ];
        return Inertia::render('PaymentResult', $data );
    }

    /**
     * Download the pdf from the given ticket id
     * @param id the ticket id
     * @return PDF
     */
    public function downloadPDF($id) {
        $ticket = Ticket::findOrFail($id);
        if($ticket->user_id != auth()->id()){
            throw new HttpException(403, "You cannot download this ticket");
        }
        $qrcode = base64_encode(QrCode::format('svg')->size(150)->errorCorrection('H')->generate($ticket->unique_code));
        $pdf = PDF::loadView('pdf', compact('ticket', 'qrcode'));

        return $pdf->download("ticket$id.pdf");
    }
}
