<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\MovieType;
use App\Models\Personality;
use App\Models\PersonalityProfessionMovie;
use App\Models\Profession;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Xylis\FakerCinema\FakerCinema\Provider;
require_once 'vendor/autoload.php';

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /* $movies = array(
            'La La Land', 'Saving Private Ryan', 'Psycho', 'The Godfather', 'Singing in the rain', 'The Artist',
            'Parasite', 'Life is beautiful', 'American Beauty', 'The Professional', 'Once Upon a Time in the West',
            'Once Upon a Time in America', 'Casablanca', 'The Pianist', 'The Departed', 'Terminator', 'Terminator 2',
            'American History X', 'Interstellar', 'The Green Mile', 'The Dark Knight', 'Batman', 'Iron Man', 'Avengers',
            'Man of Steel', 'The Watchmen', '300', '12 Angry Men', 'A bout de souffle', 'Le mépris', 'Star Wars', 'Se7en',
            'City of God', 'Fight Club', 'Gone Girl', 'The Matrix', 'The Lord of the Rings', 'GoodFellas', 'Casino',
            'Inception', 'Forrest Gump', 'Star Wars Episode V : The Empire Strikes Back', 'Memento', 'Inside Out', 'Coco',
            'The Lion King', 'Old Boy', 'Django Unchained', 'Kill Bill', 'Paths of Glory', 'The Shining', 'Enemy',
            'Citizen Kane', 'Vertigo', 'Reservoir Dogs', 'Pulp Fiction', 'Inglorious Basterds', 'Edward Cisorhands',
            'Braveheart', 'Hacksaw Ridge', 'Amadeus', 'Taxi Driver', 'Toy Story', 'Toy Story 3', 'Good Will Hunting',
            'The Shawkawk Redemption', 'Gravity', 'Drive', 'The Neon Demon', 'Gladiator', 'Shame', '12 Years a Slave',
            'Blade Runner', 'Blade Runner 2049', 'Arrival', 'Incendies', 'Polytechnique', 'Black Swan', 'Mother!',
            'Rosemary\'s Baby', 'The Aviator', 'The Irishman', 'The Wolf of Wall Street', 'Ad Astra', 'We Own the Night',
            '2001 : A Space Odyssey', 'A Clockwork Orange', 'The Schindler List', 'The Good, The Bad and The Ugly',
            'Harakiri', 'Seven Samurai', 'Joker', 'Whiplash', 'The Prestige', 'Cinema Paradiso', 'Back to the Future',
            'Back to the Future 2', 'Your Name', 'Alien', 'Rear Window', 'North by Northwest', 'The Lobster', 'Zodiac',
            'The Great Dictator', 'Eternal Sunshine of the Spotless Mind', 'Amelie from Montmartre', 'Requiem for a Dream',
            'Snatch', 'Full Metal Jacket', 'Sicario', 'Dune', 'Aliens', 'Scarface', 'Lawrence of Arabie', 'Leto', 'Hugo',
            'Green Book', 'Three Billboards Outside Ebbing Misouri', 'Seven Psychopaths', 'Silence', 'Collateral',
            'Winter Sleep', 'Warrior', 'The Wolf of Wall Street', 'There Will Be Blood', 'V for Vendetta', 'Heat',
            'A Beautiful Mind', 'L.A. Confidential', 'Raging Bull', 'Ran', 'Monty Python : Holy Grail', 'Chinatown',
            'Andreï Roublev', 'Stalker', 'The Handmaiden', 'Logan', 'Room', 'The Room', 'The Grand Budapest Hotel',
            'Moonrise Kingdom', 'Fantastic Mr.Fox', 'Ford v Ferrari', 'Spotlight', 'The Help', 'Prisoners', 'Gran Torino',
            'Mad Max : Fury Road', 'Shutter Island', 'Mary and Max', 'Dragons', 'Into the Wild', 'No Country for Old Men',
            'The Big Lebowski', 'Memories of Murder', 'Kill Bill Vol.1', 'Kill Bill Vol.2', 'Batman Returns', 'Babel',
            'Catch me if you can', 'Finding Nemo', 'The Sixth Sense', 'Unbreakable', 'Signs', 'Avatar', 'Titanic',
            'In the Mood for Love', 'Trainspotting', 'The Truman Show', 'Fargo', 'Jurassic Park', 'Stand by Me',
            'Grease', 'Platoon', 'The Deer Hunter', 'Paris, Texas', 'The Thing', 'The Hateful Height', 'Elephant Man',
            'Once Upon a Time In Hollywood', 'The Life of Brian', 'Creed', 'The Social Network', 'Panic Room', 'Persona',
            'The Girl with a Dragon Tatoo', 'Ben-hur', 'Suspiria', 'Akira', 'Jaws', 'Apocalypse Now', 'Ghostbusters',
            'Eyes Wide Shut', 'Skyfall', 'Blow Out', 'Carrie', 'Carlito\'s Way', 'Mission : Impossible', 'Cotton Club'
        );

        $faker = \Faker\Factory::create();
        $data = [];
        for($i=0; $i<count($movies); $i++){
            $data[$i] = [
                'title' => $movies[$i],
                'date_release' => $faker->date('Y_m_d'),
                'duration' => rand(3600, 10800),
                'rating' => rand(0, 100) / 10,
                'tmdb_id' => $i,
            ];
        } */


        $ids = [1018,1023,1024,1039,1040,1049,1050,1051,1052,1058,1059,1073,1075,1088,1089,1090,1091,1092,1093,1103,1114,1115,1116,1123,1124,1125,1126,1127,1162,1163,1164,1165,1285,1213,1244,1245,1246,1247,1248,1249,1250,1251,1252,1253,1254,1255,1256,1257,1259,1260,1262,1263,1264,1265,1266,1267,1268,1269,1271,1272,1273,1277,1278,1279,1280,1281,1282,1283,1284,1294,1358,1359,1360,1361,1362,1363,1364,1365,1366,1367,1368,1369,1370,1371,1372,1373,1374,1375,1376,1377,1378,1379,1380,1381,1382,1386,1387,1388,1389,1391,1392,1393,1394,1396];

        foreach($ids as $i){
            $infoMovie = Movie::tmdbGetByID($i);
            $movie = Movie::createFromTMDB($infoMovie);
            if($movie){
                $movieCredits = Movie::getCredids($infoMovie['en']['id']);
                $addedCast = Personality::addFromTMDB($movieCredits);
                $addedProfession = Profession::addFromTMDB($movieCredits, $addedCast);
                PersonalityProfessionMovie::addFromTMDB($movieCredits, $addedCast, $movie);

                $genres = [];
                $genres['en'] = $infoMovie['en']['genres'];
                $genres['fr'] = $infoMovie['fr']['genres'];
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
        }





        /* Movie::insert($data);

        $types = Type::all();
        $personalities = Personality::all();
        $professions = Profession::all(); */

        /* Movie::all()->each(function ($movie) use ($types) {
            $movie->types()->attach(
                $types->random(rand(1, 2))->pluck('id')->toArray()
            );
        }); */

        /* Movie::all()->each(function ($movie) use ($personalities, $professions) {
            PersonalityProfessionMovie::insert(
                [
                    "personality_id" => $personalities->random(1)->pluck("id")[0],
                    "profession_id" => $professions->random(1)->pluck("id")[0],
                    "movie_id" => $movie->id,
                ]
            );
        }); */
    }
}
