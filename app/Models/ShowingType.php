<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowingType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'is_event',
    ];

    public function movies(){
        return $this->hasMany(Showing::class);
    }
}
