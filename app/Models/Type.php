<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'tmdb_id', 'type_fr', 'type_en'
    ];

    public function movies(){
        return $this->belongsToMany(Movie::class, MovieType::class);
    }

    public function movieTypes(){
        return $this->hasMany(MovieType::class);
    }

    /**
     * Create the types if not present in the database
     * @param arrayData an Array of types from TMDB
     */
    public static function createIfNotPresent($arrayData){
        $toAdd = [];
        foreach($arrayData['en'] as $data){
            $finded = self::getByTMDBID($data['id']);
            if(count($finded) == 0){
                $dataFr = self::searchInArrayById($arrayData['fr'], $data['id']);
                array_push($toAdd,
                [
                    'tmdb_id' => $data['id'],
                    'type_en' => $data['name'],
                    'type_fr' => $dataFr ? $dataFr['name'] : $data['name']
                ]);
            }
        }
        Type::insert($toAdd);
    }

    private static function searchInArrayById($arrayData, $id){
        foreach($arrayData as $data){
            if($data['id'] == $id){
                return $data;
            }
        }
        return null;
    }

    public static function getByTMDBID($tmdbID){
        return self::where('tmdb_id', $tmdbID)->get();
    }
}
