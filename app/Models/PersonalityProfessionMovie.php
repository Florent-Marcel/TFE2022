<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PersonalityProfessionMovie extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'movie_id', 'profession_id', 'personality_id'
    ];

    protected $table = "personalities_professions_movies";

    public function movie(){
        return $this->belongsTo(Movie::class);
    }

    public function personality(){
        return $this->belongsTo(Personality::class);
    }

    public function profession(){
        return $this->belongsTo(Profession::class);
    }

    /**
     * link the credits to a movie
     * @param credits The credits from TMDB
     * @param addedCast The casting we have filtered and should be linked to the movie
     * @param movie The movie
     */
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
