<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Auth.vue';
import { defineComponent } from 'vue'
import { Head } from '@inertiajs/inertia-vue3';
import Modal from '@/Components/Modal.vue';
import InfoMovie from '@/Components/InfoMovie.vue';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <div class="title">
            <h3 v-if="!isEvents">Liste des séances</h3>
            <h3 v-else>Liste des évènements</h3>
        </div>
        <div class="wrapper-content">
            <div v-for="(movies, date) in showByDatesMovies" :key="date" class="movie-showings-wrapper">
                <h3 class="date-show">{{date}}</h3>
                <div v-for="(movie, idMovie) in movies" :key="idMovie">
                    <div :class="{'show-wrapper':true, 'not-last':!isLast(movies,idMovie)}">
                        <div @click="infoMovie(movie)" class="movie-title">
                        <span>{{movie.title}} - {{movie[0].language.language}} {{movie[0].room.room_type.type}}</span>
                        <span v-if="isEvents"> - {{movie[0].showing_type.type.replace("_", " ")}}</span>
                        </div>
                        <div class="time-wrapper">
                            <div v-for="show in movie" :key="show.id">
                                <Link class="time-case" :href="route('seats', show.id)">
                                    {{dateToTimeString(show.begin)}}
                                </Link>
                            </div>
                        </div>
                    </div>
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
        showings: Object,
        isEvents: {
            type: Boolean,
            default: false,
        },
    },

    data() {
        return{
            showByDatesMovies: {},
            dataMovie: {},
        }
    },

    mounted(){
        console.log(this.showings)
        this.showings.sort(function(a, b){
            let aBegin = Date.parse(a.begin);
            let bBegin = Date.parse(b.begin);
            if(aBegin < bBegin){
                return -1;
            } else if(aBegin > bBegin){
                return 1;
            }
            return 0;
        })

        for(let show of this.showings){
            let key = show.language.id+"_"+show.room.room_type.id+"_"+show.movie_id;
            let date = this.dateToString(show.begin)
            if(!this.showByDatesMovies[date]){
                this.showByDatesMovies[date] = {};
            }
            if(!this.showByDatesMovies[date][key]){
                this.showByDatesMovies[date][key] = [];
            }
            this.showByDatesMovies[date][key].push(show);
            this.showByDatesMovies[date][key]['title'] = show.movie.title
        }

        console.log(this.showByDatesMovies)
    },

    methods:{
        dateToString(date){
            let parsed = Date.parse(date);
            return new Date(parsed).toLocaleDateString();
        },
        dateToTimeString(date){
            let parsed = Date.parse(date);
            let time = new Date(parsed).toLocaleTimeString([],{
                hour: '2-digit',
                minute:'2-digit'
            });
            return time;
        },
        async infoMovie(movie){
            await this.getMovie(movie[0].movie);
            console.log(this.dataMovie)
        },
        movieClose(){
            this.dataMovie = {};
        },
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
        isLast(movies,idMovie){
            console.log(movies)
            let isLast = false;
            for(const [key, movie] of Object.entries(movies)){
                isLast = key == idMovie
            }
            return isLast;
        }
    },
    computed: {
        canScroll(){
            return Object.keys(this.dataMovie).length == 0;
        },
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
        },
    }
})

</script>

<style scoped>
.wrapper-content {
    padding-bottom: 10px;
}
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

.movie-showings-wrapper {
    width: 80%;
    max-width: 1000px;
    margin: auto;
    padding: 5px;
    background: #22577A;
    color: #F4F3F7;
    margin-bottom: 15px;
    display: flex;
    flex-direction: column;
}

@media only screen and (max-width: 700px) {
    .movie-showings-wrapper{
        width: 100%;
    }
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
    width: fit-content;
    cursor: pointer;
}

.movie-title:hover{
    filter:brightness(120%);
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

.time-wrapper{
    display: flex;
    margin: 3px;
    flex-direction: row;
    flex-wrap: wrap;
}

.show-wrapper{
    display: flex;
    justify-content: space-between;
    margin: 5px;
    padding-bottom: 7px;
}

.show-wrapper.not-last{
    border-bottom: 1px #cfe4f2 solid;
}

.time-case{
    margin-left: 5px;
    background-color: #6995B2;
    border-radius: 5px;
    padding: 3px;
    user-select: none;
    cursor: pointer;
}

.time-case:hover{
    filter:brightness(120%);
}

.date-show{
    text-align: center;
}
</style>
