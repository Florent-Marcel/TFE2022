<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Admin extends Model
{
    use HasFactory;

    public static function getToken(){
        $token = self::select('token')->first();
        return Crypt::decryptString($token->token);
    }
}
