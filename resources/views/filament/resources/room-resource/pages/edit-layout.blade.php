<?php
if(isset($_GET['maxNumPerRow'], $_GET['nbRows']) && is_numeric($_GET['maxNumPerRow']) && is_numeric($_GET['nbRows'])){
    $maxNumPerRow = $_GET['maxNumPerRow'];
    $nbRows = $_GET['nbRows'];
    $maxSeat = ($maxNumPerRow*$nbRows);
}

?>


<x-filament::page>

<form action="" method="get">
    <label for="maxNumPerRow">Max seat per row</label>
    <input type="number"
            name="maxNumPerRow"
            pattern="\d*"
            value=<?= isset($maxNumPerRow) ? $maxNumPerRow : 0?>
            min=5
            required
            />
    <label for="nbRows">Number of rows</label>
    <input type="number"
            name="nbRows"
            pattern="\d*"
            value=<?= isset($nbRows) ? $nbRows : 0?> 
            min=5
            required
            />
    <input type="submit" value="Apply" style="cursor:pointer;" class="inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset filament-button min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
</form>

<?php if(isset($maxNumPerRow, $nbRows)) {?>
    <div class="layout-wrapper">
        <hr class="screen">
        <form method="post">
            <div class="grid">
                <?php 
                for($i=1; $i<=$maxSeat; $i++){
                        echo '<div name="'.$i.'" id="'.$i.'"><input type="checkbox"></div>';
                }
                ?>
            </div>
        </form>
    </div>
<?php } ?>
</x-filament::page>



<style>
.grid{
        display: grid;
        grid-template-columns: repeat(<?= isset($maxNumPerRow) ? $maxNumPerRow : 4 ?>, [col-start] 20px [col-end]);
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

</style>