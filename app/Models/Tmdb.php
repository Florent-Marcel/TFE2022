<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class Tmdb extends Model
{

    protected $fillables = [
        'key', 'base_url', 'base_url_img'
    ];

    use HasFactory;

    private static function getDecryptedData(){
        $data = self::latest()->first();
        $data->key = Crypt::decryptString($data->key);

        return $data;
    }

    /**
     * Search a movie by title and year with TMDB
     * @param title The title of the movie
     * @param year The year of release of the movie
     * @return JSON The result
     */
    public static function search($title, $year){
        $data = self::getDecryptedData();

        $url = $data->base_url."/search/movie?api_key=".$data->key."&query=".$title."&year=".$year;

        $response = Http::get($url);

        return $response->json();
    }

    /**
     * Get a movie on TMDB by id
     * @param tmdbID the ID of the movie on TMDB
     * @return Array the data of the movie with english and frensh translations
     */
    public static function getByID($tmdbID){
        $data = self::getDecryptedData();

        $url = $data->base_url."/movie/$tmdbID?api_key=".$data->key;
        $response = Http::get($url);
        $en = $response->json();
        if(isset($en['poster_path']) && $en['poster_path']){
            $en['poster_url'] = $data->base_url_img.$en['poster_path'];
        }

        $url = $data->base_url."/movie/$tmdbID?api_key=".$data->key."&language=fr-BE";
        $response = Http::get($url);
        $fr=$response->json();
        if(isset($fr['poster_path']) && $fr['poster_path']){
            $fr['poster_url'] = $data->base_url_img.$fr['poster_path'];
        }

        if(isset($en['overview'])){
            $fr['overview'] = $fr['overview'] ? $fr['overview'] : $en['overview'];
        }

        if(isset($fr['overview'])){
            $en['overview'] = $en['overview'] ? $en['overview'] : $fr['overview'];
        }

        return ['en' => $en, 'fr' => $fr];
    }

    /**
     * Get the credits of a given tmdb id movie
     * @param tmdbID The id on TMDB
     * @return Object of credits
     */
    public static function getCredits($tmdbID){
        $data = self::getDecryptedData();

        $url = $data->base_url."/movie/$tmdbID/credits?api_key=".$data->key;
        $response = Http::get($url);
        $response = $response->json();

        return $response;
    }
}
