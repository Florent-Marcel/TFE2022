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

        <div class="filter-wrapper">
            <div class="filter">
                <span class="filter-label">Genre</span>
                <VueMultiselect :options="genres" label="type" v-model="filters.genre">
                </VueMultiselect>
            </div>
            <div class="filter">
                <span class="filter-label">Title</span>
                <VueMultiselect :options="titles" v-model="filters.title">
                </VueMultiselect>
            </div>
        </div>

        <div class="movie-wrapper">
            <div class="movie-rectangle" v-for="movie in movies" :key="movie.id" v-show="filter(movie)">
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

    data() {
        return {
            filters: {
                genre: null,
                title: null,
                },
        }
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
        },

        filter(movie){
            let res = true;
            res = res && this.filterByGenre(movie)
            res = res && this.filterByTitle(movie)
            return res;
        },
        filterByGenre(movie){
            if(!this.filters.genre){
                return true;
            }
            let res = movie.types && movie.types.length > 0;
            if(res){
                let finded = movie.types.find(x => x.id == this.filters.genre.id)
                res = finded != null && finded != undefined
            }
            return res;
        },
        filterByTitle(movie){
            if(!this.filters.title){
                return true;
            }
            return movie.title.includes(this.filters.title)
        }
    },
    computed: {
        titles(){
            return this.movies.map(x => x.title);
        },
        filterTitle(){
            return this.filters.title;
        },
        genres(){
            let genres = []
            let movies = this.movies;
            if(this.filters.title){
                movies = movies.filter(x => this.filterByTitle(x));
            }
            for(let movie of movies){
                if(movie.types){
                    for(let genre of movie.types){
                        let finded = genres.find(x => x.id == genre.id);
                        if(!finded){
                            genres.push(genre);
                        }
                    }
                }
            }
            return genres;
        }
    },
    watch: {
    }
})

</script>

<style scoped>
.title{
    text-align: center;
}

.filter-wrapper{
    height: fit-content;
    width: 50%;
    background: #22577A;
    margin: auto;
    display: flex;
    padding: 5px;
}

.filter-wrapper .filter{
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 300px;
    margin: 5px;
}

.filter-wrapper .filter span{
    font-weight: bold;
    color: #F4F3F7;
}

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