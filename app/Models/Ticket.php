<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_code', 'is_used', 'is_blocked',
    ];

    public function user(){
        return $this->hasOne(User::class);
    }

    public function showing(){
        return $this->hasOne(Showing::class);
    }
}