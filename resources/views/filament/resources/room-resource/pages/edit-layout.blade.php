<?php

    if (preg_match('/rooms\/(.*?)\/layout/', url()->current(), $match) == 1) {
        $this->idRoom = $match[1];
        $this->init();
    }
    if(!$this->previousUrl){
        $this->previousUrl = url()->previous();
    }
    $maxSeat = ($this->maxNumPerRow*$this->nbRows);
?>


<x-filament::page>
<style>
    .grid{
            display: grid;
            grid-template-columns: repeat(<?= isset($this->maxNumPerRow) ? $this->maxNumPerRow : 4 ?>, [col-start] 20px [col-end]);
    }
    .grid div{
            margin: 1px;
            max-width: fit-content;
    }
    .layout-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: fit-content;
        margin: auto;
    }
    .layout-wrapper .screen{
        color: black;
        background-color: black;
        width: 80%;
        height: 2px;
        margin-bottom: 50px;
    }

    .button{
        cursor: pointer;
        margin-top: 20px;
    }
</style>
<div>


    <div class="layout-wrapper">
        <hr class="screen">
            <div class="grid">
                <?php
                for($i=1; $i<=$maxSeat; $i++){
                        echo '<div><input name="'.$i.'" id="'.$i.'" type="checkbox" class="seat" onclick="test()"></div>';
                }
                ?>
            </div>
    </div>

    <input type="submit" value="Save" wire:click="editLayout()" class="button inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset filament-button min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
    <form action="<?=$this->previousUrl?>" class="inline-flex">
        <input type="submit" value="Cancel" class="button inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset filament-button min-h-[2.25rem] px-4 text-sm text-gray-800 bg-white border-gray-300 hover:bg-gray-50 focus:ring-primary-600 focus:text-primary-600 focus:bg-primary-50 focus:border-primary-600 filament-page-button-action">
    </form>

</div>
<script >
    function test(){
        let seats = document.getElementsByClassName("seat")
        let num_seat = 1;
        if(seats.length){
            let res = {};
            for(let seat of seats){
                res[seat.name] = {};
                if(seat.checked){
                    res[seat.name].num_seat=num_seat;
                    num_seat++;
                }
                res[seat.name].activated = seat.checked;
            }
            let json = JSON.stringify(res);
            let nb_places = (json.match(/true/g) || []).length;
            @this.set('json', json);
            @this.set('nbPlaces', nb_places);
        }
    }
    function init(){
        let seats = document.getElementsByClassName("seat")
        let json = '<?=$this->json?>';
        json = JSON.parse(json);
        for (const [key, value] of Object.entries(json)) {
            if(value.activated){
                seats[key-1].checked = true;
            }
        }
    }
    init();
</script>
</x-filament::page>



