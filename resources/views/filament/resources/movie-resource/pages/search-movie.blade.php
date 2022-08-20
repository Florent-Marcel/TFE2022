<?php
        use App\Models\Tmdb; 
        $title = isset($_GET['title']) ? $_GET['title'] : '';
        $year = isset($_GET['year']) ? $_GET['year'] : '';
        $data = null;
        if($title){
                $data = Tmdb::search($title, $year);
        }
?>
<x-filament::page>

<form action="#" method="get">
        <label for="title">Title</label>
        <x-input type="text"
            name="title"
            :value="$title"
            />
        <label for="year">Year</label>
        <x-input type="number"
            name="year"
            :value="$year"
            />
        <input type="submit" value="Search" class="button cursor-pointer inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset filament-button min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
</form>

@if($data && isset($data['results']) && count($data['results']) > 0)
        <form action="/admin/movies/create" method="get">
                @foreach($data['results'] as $movie)
                        <input type="radio" name="idTMDB" value={{$movie['id']}} id={{$movie['id']}} required/>
                        <label for={{$movie['id']}}>{{$movie['title']}} ({{isset($movie['release_date']) ? $movie['release_date'] : ''}})</label><br/>
                @endforeach
                <br/>
                <input type="submit" value="Apply" class="button cursor-pointer inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset filament-button min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
        </form>
@endif


</x-filament::page>
