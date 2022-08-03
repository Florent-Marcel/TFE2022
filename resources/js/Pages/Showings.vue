<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Auth.vue';
import { defineComponent } from 'vue'
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <div class="title">
            <h3>Liste des séances</h3>
        </div>

        <div v-for="(movies, date) in showByDatesMovies" :key="date" class="movie-showings-wrapper">
            <h3 class="date-show">{{date}}</h3>
            <div v-for="(movie, idMovie) in movies" :key="idMovie">
                <div class="show-wrapper">
                    <div class="movie-title">{{movie.title}}</div>
                    <div class="time-wrapper">
                        <div v-for="show in movie" :key="show.id">
                            <div class="time-case">
                                {{dateToTimeString(show.begin)}}
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>

export default defineComponent({
    props:{
        showings: Array,
    },

    data() {
        return{
            showByDatesMovies: {},
        }
    },

    mounted(){
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
            let date = this.dateToString(show.begin)
            if(!this.showByDatesMovies[date]){
                this.showByDatesMovies[date] = {};
            }
            if(!this.showByDatesMovies[date][show.movie_id]){
                this.showByDatesMovies[date][show.movie_id] = [];
            }
            this.showByDatesMovies[date][show.movie_id].push(show);
            this.showByDatesMovies[date][show.movie_id]['title'] = show.movie.title
        }
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
        }
    },
    computed: {
       
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
    margin: auto;
    padding: 5px;
    background: #22577A;
    color: #F4F3F7;
    margin-bottom: 15px;
    display: flex;
    flex-direction: column;
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
}

.show-wrapper{
    display: flex;
    justify-content: space-between;
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