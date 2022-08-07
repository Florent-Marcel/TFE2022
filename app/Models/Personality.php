<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personality extends Model
{
    use HasFactory;

    protected $fillable = [
        'tmdb_id', 'name', 'profile_url',
    ];

    public function personalitiesProfessionsMovies(){
        return $this->hasMany(PersonalityProfessionMovie::class);
    }

    public function movies(){
        return $this->belongsToMany(Movie::class, PersonalityProfessionMovie::class);
    }

    public function professions(){
        return $this->belongsToMany(Profession::class, PersonalityProfessionMovie::class);
    }

    public static function addFromTMDB($tmdbData){
        $toAdd = [];
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
                    if($found_key === false && count(self::getByTMDBID($cast['id'])) == 0){
                        array_push($toAdd, [
                            'tmdb_id' => $cast['id'],
                            'name' => $cast['name'],
                            'profile_url' => isset($cast['profile_path']) ? "https://image.tmdb.org/t/p/w300".$cast['profile_path'] : "",
                        ]);
                    }
                }
            }
        }
        if(count($toAdd) > 0){
            self::insert($toAdd);
        }

        return $toAdd;
    }

    public static function getByTMDBID($tmdbID){
        return self::where('tmdb_id', $tmdbID)->get();
    }
}
