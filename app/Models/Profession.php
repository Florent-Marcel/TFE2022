<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'profession',
    ];

    public function moviesPersonalitiesProfessions(){
        return $this->hasMany(MoviePersonalityProfession::class);
    }

    public function personalities(){
        return $this->belongsToMany(Personality::class, MoviePersonalityProfession::class);
    }

    public function movies(){
        return $this->belongsToMany(Movie::class, MoviePersonalityProfession::class);
    }

    /**
     * Add the professions from TMDB
     * @param tmdbData the casting from TMDB
     * @param addedCast the casting that have to be added
     * @return array of professions that have been added
     */
    public static function addFromTMDB($tmdbData, $addedCast){
        $toAdd = [];
        unset($tmdbData['id']);
        $tmdb_ids = array_column($addedCast, 'tmdb_id');

        foreach($tmdbData as $data){
            foreach($data as $cast){
                $need = false;
                $found_key = array_search($cast['id'], $tmdb_ids);

                if($found_key !== false){
                    $toFound = isset($cast['job']) ? $cast['job'] : $cast['known_for_department'];
                    $toFound = $toFound == "Acting" ? "Actor" : $toFound;
                    $professions = array_column($toAdd, 'profession');
                    $found_key = array_search($toFound, $professions);

                    if($found_key === false && count(self::getByProfession($toFound)) == 0){
                        array_push($toAdd, [
                            'profession' => $toFound,
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

    public static function getByProfession($profession){
        return self::where('profession', $profession)->get();
    }
}

