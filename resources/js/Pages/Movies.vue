<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Auth.vue';
import Modal from '@/Components/Modal.vue';
import InfoMovie from '@/Components/InfoMovie.vue';
import { defineComponent } from 'vue'
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head :title="__('Movies')" />

    <BreezeAuthenticatedLayout>
        <div class="title">
            <h3>{{__("List of movies")}}</h3>
        </div>

        <div class="filter-wrapper">
            <div class="filter">
                <span class="filter-label">{{__("Type")}}</span>
                <VueMultiselect :options="genres" :label="$t('type')" v-model="filters.genre">
                </VueMultiselect>
            </div>
            <div class="filter">
                <span class="filter-label">{{__("Title")}}</span>
                <VueMultiselect :options="titles" v-model="filters.title">
                </VueMultiselect>
            </div>
        </div>

        <div class="movie-wrapper" scroll="false">
            <div class="movie-rectangle" v-for="movie in movies" :key="movie.id" v-show="filter(movie)" @click="getMovie(movie)">
                <div class="movie-title">
                    <span>{{movie[$t('title')]}}</span>
                </div>
                <div class="movie-poster">
                    <img v-if="movie.poster_url && movie.canLoadIMG" :src="movie.poster_url" @load="loadNext()">
                    <img v-else>
                </div>
                <div class="movie-dates" v-if="findExtremitySceance(movie.showings, true) != findExtremitySceance(movie.showings, false)">
                    {{__("From")}} {{dateToString(findExtremitySceance(movie.showings, true))}} {{__("to")}} {{dateToString(findExtremitySceance(movie.showings, false))}}
                </div>
                <div class="movie-dates" v-else>
                    {{dateToString(findExtremitySceance(movie.showings, true))}}
                </div>
            </div>
        </div>

    </BreezeAuthenticatedLayout>
    <Modal :enabled="true" v-if="dataMovie.id" @close="movieClose">
        <InfoMovie :movie="dataMovie"></InfoMovie>
    </Modal>
</template>

<script>

export default defineComponent({
    props:{
        movies: Object,
    },

    data() {
        return {
            filters: {
                genre: null,
                title: null,
                },
            loadIndex: 0,
            maxImgLoadSimultaneous: 20,
            dataMovie: {},
        }
    },

    beforeMount(){
        for(let movie of this.movies){
            movie.canLoadIMG = false
            if(this.loadIndex < this.maxImgLoadSimultaneous){
                movie.canLoadIMG = true;
                this.loadIndex++;
            }
        }
    },

    methods:{
        async getMovie(movie){
            if(movie && movie.id){
                let app = this;
                return axios.get("/api/movie/"+movie.id)
                    .then(function(response){
                        app.dataMovie = response.data;
                        return app.dataMovie;
                    })
                    .catch(function(response){
                        console.log(response)
                    })
            }
        },
        movieClose(){
            this.dataMovie = {};
        },
        loadNext(){
            if(this.movies[this.loadIndex]){
                this.movies[this.loadIndex].canLoadIMG = true;
            }
            this.loadIndex++;
        },
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
            return movie[this.$t('title')].includes(this.filters.title)
        }
    },
    computed: {
        titles(){
            return this.movies.map(x => x[this.$t('title')]);
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
        },
        canScroll(){
            return Object.keys(this.dataMovie).length == 0;
        }
    },
    watch: {
        dataMovie(){
            if(this.canScroll){
                window.onscroll=function(){}
            } else{
                let x = window.scrollX;
                let y = window.scrollY;
                window.onscroll=function(){window.scrollTo(x, y);}
            }
        }
    }
})

</script>

<style>
.stop-scrolling {
    height: 100%;
    overflow: hidden;
}
</style>

<style scoped>

.title{
    text-align: center;
}

.filter-wrapper{
    height: fit-content;
    width: fit-content;
    background: #22577A;
    margin: auto;
    display: flex;
    justify-content: center;
    padding: 5px;
    flex-wrap: wrap;
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
    width: 80%;
    margin: auto;
}
</style>
