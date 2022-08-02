<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Auth.vue';
import { defineComponent } from 'vue'
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="title">
            <h3>Liste des films à l'affiche</h3>
        </div>
        <div class="movie-wrapper">
            <div class="movie-rectangle" v-for="movie in movies" :key="movie.id">
                <div class="movie-title">
                    <span>{{movie.title}}</span>
                </div>
                <div class="movie-poster">
                    <img>
                </div>
                <div class="movie-dates" v-if="findExtremitySceance(movie.showings, true) != findExtremitySceance(movie.showings, false)">
                    Du {{dateToString(findExtremitySceance(movie.showings, true))}} au {{dateToString(findExtremitySceance(movie.showings, false))}}
                </div>
                <div class="movie-dates" v-else>
                    Le {{dateToString(findExtremitySceance(movie.showings, true))}}
                </div>
            </div>
        </div>
        
    </BreezeAuthenticatedLayout>
</template>

<script>

export default defineComponent({
    props:{
        movies: Array,
    },

    mounted(){
    },

    methods:{
        findExtremitySceance(sceances, first=false){
            let current = null;
            for(let sceance of sceances){
                if(!current && sceance.begin){
                    current = sceance.begin
                }
                else{
                    if(first && Date.parse(sceance.begin) <= Date.parse(current)){
                        current = sceance.begin
                    } else if(!first && Date.parse(sceance.begin) >= Date.parse(current)){
                        current = sceance.begin
                    }
                }
            }
            return Date.parse(current)
        },

        dateToString(date){
            return new Date(date).toLocaleDateString();
        }
    }
})

</script>

<style scoped>
.movie-rectangle {
    width: 215px;
    background: #22577A;
    color: #F4F3F7;
    margin: 10px 10px 10px 10px;
    cursor: pointer;
}

.movie-rectangle:hover {
    filter:brightness(120%);
}

.movie-poster img{
    width: 215px;
    height: 323px;
}

.movie-title {
    font-weight: bold;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.movie-title span {
    font-family: 'Nunito-black';
    text-align: center;
}

.movie-dates {
    height: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.movie-wrapper {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
}
</style>