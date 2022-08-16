<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TemporaryTicket extends Model
{
    use HasFactory;

    private static $durationValidityM = 30;

    protected $fillable = [
        'code', 'num_seat', 'showing_id', 'user_id',
    ];

    public function showing(){
        $this->belongsTo(Showing::class);
    }

    public function user(){
        $this->belongsTo(User::class);
    }

    public static function getTemporaryTicketFromAuth($code){
        $res= self::select('*')->where([
            ['code', '=', $code],
            ['user_id', '=', Auth::id()],
        ])->get();

        return $res->toArray();
    }

    public static function getTemporaryTicketByShow($showId){
        $res= self::select('*')->where([
            ['showing_id', '=', $showId],
        ])->get();

        return $res->toArray();
    }

    public static function getTemporaryTicketByCode($code){
        $res= self::select('*')->where([
            ['code', '=', $code],
        ])->get();

        return $res;
    }

    public static function createTemporaryTickets($showId, $seats, $code){
        if(!Showing::seatsStillAvailable($showId, $seats)){
            return false;
        }
        $show = Showing::findOrFail($showId);
        $data = [];
        foreach($seats as $seat){
            array_push($data, [
                "code" => $code,
                "showing_id" => intval($showId),
                "num_seat" => intval($seat),
                "user_id" => Auth::id(),
                "created_at" => now('Europe/Brussels')
            ]);
        }
        return self::insert($data);
    }

    public static function deleteLastFromUser(){
        if(!auth()->hasUser()){
            return false;
        }
        $userId = auth()->id();
        $temp = TemporaryTicket::where('user_id', '=', $userId)->latest()->first();
        if(!$temp){
            return false;
        }

        return TemporaryTicket::where('code', '=', $temp->code)->delete();
    }

    public static function checkPayment($tempTickets, $payment){
        $payed = $payment->amount->value;
        $payed = floatval($payed);

        $price = 0.0;
        $show = Showing::findOrFail($tempTickets[0]->showing_id);
        $price = $show->price * count($tempTickets);
        $price = floor($price * 100) / 100;

        return floatval($price) == $payed;
    }

    public static function deleteOld(){
        $now = now('Europe/Brussels');
        $validityLimit = $now->subMinutes(self::$durationValidityM);
        $tickets = self::where('created_at', '<=', $validityLimit)->delete();
    }
}
