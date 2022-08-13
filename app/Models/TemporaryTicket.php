<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TemporaryTicket extends Model
{
    use HasFactory;

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
                "created_at" => now()
            ]);
        }
        return self::insert($data);
    }
}
