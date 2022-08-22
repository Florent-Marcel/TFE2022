<?php

namespace App\Models;

use GuzzleHttp\Client;
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

    public static function getClientId(){
        $data = self::getDecryptedData();
        return $data->client_id;
    }

    private static function auth($data){
        $url = $data->base_url."/v1/oauth2/token";
        $client = new Client();
        $res = $client->post($url, [
            "auth" => [
                $data->client_id,
                $data->secret,
            ],
            "headers" => [
                "Accept" => "application/json",
                "Content-Type" => "application/x-www-form-urlencoded",
            ],
            "form_params" => [
                "grant_type" => "client_credentials",
            ],
        ]);
        if($res->getStatusCode() != 200){
            return false;
        }

        return json_decode($res->getBody()->getContents());
    }

    /**
     * Get the info on a Paypal caputre
     * @param idCapture The id of the Paypal capture.
     */
    public static function getcapture($idCapture){
        $data = self::getDecryptedData();
        $auth = self::auth($data);
        if(!$auth){
            return false;
        }

        $url = $data->base_url."/v2/payments/captures/$idCapture";
        $accessTocken = $auth->access_token;
        $client = new Client();

        $res = $client->get($url, [
            "headers" => [
                "Authorization" => "Bearer $accessTocken",
            ],
        ]);

        if($res->getStatusCode() != 200){
            return false;
        }

        return json_decode($res->getBody()->getContents());
    }
}
