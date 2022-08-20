<script setup>
import Base from '@/Layouts/Base.vue';
import Modal from '@/Components/Modal.vue';
import InfoMovie from '@/Components/InfoMovie.vue';
import MovieRectange from '@/Components/MovieRectangle.vue';
import { defineComponent } from 'vue'
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head :title="__('Home')" />

    <Base>
        <div class="title">
            <h3>{{__("Welcome to Cinemar!")}}</h3>
        </div>

        <div>
            <h3 class="sub-title">{{__("Most popular movies")}}</h3>
        </div>
        <div class="movie-wrapper" scroll="false">
            <div class="movie-rectangle" v-for="movie in moviesPopular" :key="movie.id" @click="getMovie(movie)">
                <MovieRectange :movie="movie" @loadnext="loadNextMoviesPopular()"></MovieRectange>
            </div>
        </div>

        <div>
            <h3 class="sub-title">{{__("Top rated movies")}}</h3>
        </div>
        <div class="movie-wrapper" scroll="false">
            <div class="movie-rectangle" v-for="movie in moviesRated" :key="movie.id" @click="getMovie(movie)">
                <MovieRectange :movie="movie" @loadnext="loadNextMoviesPopular()"></MovieRectange>
            </div>
        </div>

    </Base>
    <Modal :enabled="true" v-if="dataMovie.id" @close="movieClose">
        <InfoMovie :movie="dataMovie"></InfoMovie>
    </Modal>
</template>

<script>

export default defineComponent({
    props:{
        moviesPopular: Object,
        moviesRated: Object,
    },

    data() {
        return {
            filters: {
                genre: null,
                title: null,
                },
            loadIndexMoviesPopular: 0,
            loadIndexmoviesRated: 0,
            maxImgLoadSimultaneous: 20,
            dataMovie: {},
        }
    },

    beforeMount(){
        for(let movie of this.moviesPopular){
            movie.canLoadIMG = false
            if(this.loadIndexMoviesPopular < this.maxImgLoadSimultaneous){
                movie.canLoadIMG = true;
                this.loadIndexMoviesPopular++;
            }
        }
        for(let movie of this.moviesRated){
            movie.canLoadIMG = false
            if(this.loadIndexmoviesRated < this.maxImgLoadSimultaneous){
                movie.canLoadIMG = true;
                this.loadIndexmoviesRated++;
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
                    })
            }
        },
        movieClose(){
            this.dataMovie = {};
        },
        loadNextMoviesPopular(){
            if(this.moviesPopular[this.loadIndex]){
                this.moviesPopular[this.loadIndex].canLoadIMG = true;
            }
            this.loadIndexMoviesPopular++;
        },

        loadNextMoviesRated(){
            if(this.moviesRated[this.loadIndex]){
                this.moviesRated[this.loadIndex].canLoadIMG = true;
            }
            this.loadIndexMoviesRated++;
        },
    },
    computed: {
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
    width: 95%;
    margin: auto;
    margin-bottom: 20px;
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

.sub-title{
    margin-top: 30px;
    text-align: center;
    color:#22577A;
}


</style>
