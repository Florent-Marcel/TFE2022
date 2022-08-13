<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_code', 'is_used', 'is_blocked', 'user_id', 'showing_id', 'num_seat', 'paypal_captures_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function showing(){
        return $this->belongsTo(Showing::class);
    }

    public function create($showId, $numSeat, $paypalCapId){
        return self::insert([
            "unique_code" => Uuid::uuid1(),
            "is_used" => false,
            "is_blocked" => false,
            "user_id" => auth()->id(),
            "showing_id" => $showId,
            "num_seat" => $numSeat,
            "paypal_captures_id" => $paypalCapId,
        ]);
    }


}
