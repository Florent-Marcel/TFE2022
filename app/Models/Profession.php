<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profession extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'profession',
    ];

    public function personalitiesProfessionsMovies(){
        return $this->hasMany(PersonalityProfessionMovie::class);
    }

    public function personalities(){
        return $this->belongsToMany(Personality::class, PersonalityProfessionMovie::class);
    }

    public function movies(){
        return $this->belongsToMany(Movie::class, PersonalityProfessionMovie::class);
    }

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

