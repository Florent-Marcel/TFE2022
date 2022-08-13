<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Paypal extends Model
{
    use HasFactory;

    protected $fillable = [
        'account', 'client_id', 'secret', 'base_url'
    ];

    private static function getDecryptedData(){
        $data = self::latest()->first();
        $data->client_id = Crypt::decryptString($data->client_id);
        $data->secret = Crypt::decryptString($data->secret);

        return $data;
    }
}
