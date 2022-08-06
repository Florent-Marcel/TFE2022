<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PersonalityProfessionMovie extends Model
{
    use HasFactory;

    protected $table = "personalities_professions_movies";

    public function movies(){
        return $this->belongsToMany(Movie::class);
    }

    public function personalities(){
        return $this->belongsToMany(Personality::class);
    }

    public function professions(){
        return $this->belongsToMany(Profession::class);
    }

    public static function addFromTMDB($credits, $addedCast, $movie){
        $toAdd = [];
        unset($credits['id']);
        $tmdb_ids = array_column($addedCast, 'tmdb_id');

        foreach($credits as $data){
            foreach($data as $credit){
                $found_key = array_search($credit['id'], $tmdb_ids);
                if($found_key !== false){
                    $profession = isset($credit['job']) ? $credit['job'] : $credit['known_for_department'];
                    $profession = $profession == 'Acting' ? 'Actor' : $profession;
                    $profession = Profession::getByProfession($profession);
                    $personality = Personality::getByTMDBID($credit['id']);
                    if(count($profession) > 0 && count($personality) > 0){
                        array_push($toAdd, [
                            'personality_id' => $personality[0]->id,
                            'profession_id' => $profession[0]->id,
                            'movie_id' => $movie->id,
                        ]);
                    }
                }
            }
        }
        self::insert($toAdd);
    }
}
