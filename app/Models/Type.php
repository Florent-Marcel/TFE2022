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
        'tmdb_id', 'type'
    ];

    public function movies(){
        return $this->belongsToMany(Movie::class, MovieType::class);
    }

    public function movieTypes(){
        return $this->hasMany(MovieType::class);
    }

    //Array from tmdb structured like this:
    // ['id' => integer, 'name' => string]
    public static function createIfNotPresent($arrayData){
        $toAdd = [];
        foreach($arrayData as $data){
            $finded = self::getByTMDBID($data['id']);
            if(count($finded) == 0){
                array_push($toAdd,
                [
                    'tmdb_id' => $data['id'],
                    'type' => $data['name']
                ]);
            }
        }
        Type::insert($toAdd);
    }

    public static function getByTMDBID($tmdbID){
        return self::where('tmdb_id', $tmdbID)->get();
    }
}
