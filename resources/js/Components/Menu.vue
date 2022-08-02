<script setup>
import { defineComponent } from 'vue'
</script>

<template>
    <div class="menu">
        <div class="elem-menu">
            <a class="actif" href="./films.html">Films</a>
            <div class="actif-bar"></div>
        </div>
        <div class="elem-menu">
            <a href="./seances.html">Séances</a>
        </div>
    </div>
</template>


<script>

export default defineComponent({
    props:{
    }
})

</script>

<style scoped>
.menu{
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    align-content: center;
    background: #22577A;
    color: #F4F3F7;
}

.menu .elem-menu{
    padding-left: 5px;
    padding-right: 5px;
    height: 35px;
    display: flex;
    align-items: center;
    position: relative;
    flex-wrap: wrap;
    justify-content: center;
    cursor: pointer;
}

.menu .elem-menu a {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
}
.menu .elem-menu:hover{
    filter:brightness(150%);
}

.menu .elem-menu .actif{
    font-family: 'Nunito-black';
}

.elem-menu .actif-bar {
    width: 100%;
    background: #DDDAE7;
    height: 5px;
    position: absolute;
    bottom: 0px;
}
</style>