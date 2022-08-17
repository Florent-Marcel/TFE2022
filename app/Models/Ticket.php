<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_code', 'is_used', 'is_blocked', 'user_id', 'showing_id', 'num_seat', 'paypal_capture_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function showing(){
        return $this->belongsTo(Showing::class);
    }

    public static function create($showId, $numSeat, $paypalCapId){
        return self::insert([
            "unique_code" => Uuid::uuid4(),
            "is_used" => false,
            "is_blocked" => false,
            "user_id" => auth()->id(),
            "showing_id" => $showId,
            "num_seat" => $numSeat,
            "paypal_capture_id" => $paypalCapId,
            "created_at" => now(),
        ]);
    }

    public static function getByIdCapture($captureId){
        return self::where("paypal_capture_id", "=", "$captureId")->get();
    }

    public static function getByUser($idUser){
        $tickets = self::where('user_id', $idUser)
            ->with(['showing' => function($query){
                $query->where('begin', '>=', now())
                        ->with('movie')
                        ->with('language')
                        ->with('showingType')
                        ->with(['room' => function($query){
                            $query->with('roomType');
                        }]);
            }])->has('showing', '>', 0)->get();

        return $tickets;
    }
}
