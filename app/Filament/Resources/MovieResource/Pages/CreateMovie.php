<?php

namespace App\Filament\Resources\MovieResource\Pages;

use App\Filament\Resources\MovieResource;
use App\Models\Movie;
use App\Models\MovieType;
use App\Models\Personality;
use App\Models\MoviePersonalityProfession;
use App\Models\Profession;
use App\Models\Tmdb;
use App\Models\Type;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMovie extends CreateRecord
{
    protected static string $resource = MovieResource::class;

    protected function handleRecordCreation(array $data): Movie
    {
        $movie = static::getModel()::create($data);

        if(isset($data['tmdb_data'])){
            $tmdbData = json_decode($data['tmdb_data'], true);

            if(!isset($tmdbData['en'])){
                return $movie;
            }

            $movieCredits = Tmdb::getCredits($tmdbData['en']['id']);
            $addedCast = Personality::addFromTMDB($movieCredits);
            $addedProfession = Profession::addFromTMDB($movieCredits, $addedCast);

            MoviePersonalityProfession::addFromTMDB($movieCredits, $addedCast, $movie);

            $genres = [];
            $genres['en'] = $tmdbData['en']['genres'];
            $genres['fr'] = $tmdbData['fr']['genres'];
            Type::createIfNotPresent($genres);
            $movieTypesToAdd = [];
            foreach($genres['en'] as $genre){
                $types = Type::getByTMDBID($genre['id']);
                if(count($types) > 0){
                    array_push($movieTypesToAdd, ['movie_id' => $movie->id, 'type_id' => $types[0]->id]);
                }
            }
            MovieType::insert($movieTypesToAdd);
        }
        return $movie;
    }
}
