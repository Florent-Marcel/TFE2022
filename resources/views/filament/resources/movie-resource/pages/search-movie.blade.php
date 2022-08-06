<x-filament::page>

<form action="/admin/movies/create" method="get">
    <label for="title">Title</label>
    <input type="text"
            name="title"
            />
    <label for="year">Year</label>
    <input type="number"
            name="year"
            />
    <input type="submit" value="Apply">
</form>

</x-filament::page>
