<?php

namespace App\Filament\Resources\RoomResource\Pages;

use App\Filament\Resources\RoomResource;
use App\Models\Room;
use Filament\Resources\Pages\Page;

class EditLayout extends Page
{
    public $idRoom;
    public $object = "";
    public $json;
    public $maxNumPerRow;
    public $nbRows;
    public $nbPlaces;
    public $previousUrl;
    protected $room;


    protected static string $resource = RoomResource::class;

    protected static string $view = 'filament.resources.room-resource.pages.edit-layout';

    public function editLayout(){
        if(!$this->room){
            $this->room = Room::findOrFail($this->idRoom);
        }
        $this->room->layout_json = $this->json;
        $this->room->nb_places = $this->nbPlaces;
        $this->room->save();
    }

    public function init(){
        $this->room = Room::findOrFail($this->idRoom);

        $this->maxNumPerRow = $this->room->max_places_row;
        $this->nbRows = $this->room->nb_rows;
        $this->json = $this->room->layout_json;
        $this->nbPlaces = $this->room->nb_places;
    }

}
