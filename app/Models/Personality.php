<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personality extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'tmdb_id', 'name', 'profile_url',
    ];

    public function moviesPersonalitiesProfessions(){
        return $this->hasMany(MoviePersonalityProfession::class);
    }

    public function movies(){
        return $this->belongsToMany(Movie::class, MoviePersonalityProfession::class);
    }

    public function professions(){
        return $this->belongsToMany(Profession::class, MoviePersonalityProfession::class);
    }

    /**
     * Add the personalities getted from TMDB
     * @param tmdbData the casting from TMDB
     * @return array of personalities that have to be linked to a movie
     */
    public static function addFromTMDB($tmdbData){
        $toAdd = [];
        $res = [];
        unset($tmdbData['id']);
        foreach($tmdbData as $data){
            foreach($data as $cast){
                $need = false;
                if(isset($cast['known_for_department']) && $cast['known_for_department'] == 'Acting'){
                    $need = isset($cast['profile_path']) && $cast['profile_path'];
                }
                if(isset($cast['job']) && $cast['job'] == 'Director'){
                    $need = true;
                }

                if($need){
                    $tmdb_ids = array_column($toAdd, 'tmdb_id');
                    $found_key = array_search($cast['id'], $tmdb_ids);
                    $data = [
                        'tmdb_id' => $cast['id'],
                        'name' => $cast['name'],
                        'profile_url' => isset($cast['profile_path']) ? "https://image.tmdb.org/t/p/w300".$cast['profile_path'] : "",
                    ];
                    array_push($res, $data);
                    if($found_key === false && count(self::getByTMDBID($cast['id'])) == 0){
                        array_push($toAdd, $data);
                    }
                }
            }
        }
        if(count($toAdd) > 0){
            self::insert($toAdd);
        }

        return $res;
    }

    public static function getByTMDBID($tmdbID){
        return self::where('tmdb_id', $tmdbID)->get();
    }
}
