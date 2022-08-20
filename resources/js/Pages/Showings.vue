<script setup>
import Base from '@/Layouts/Base.vue';
import { defineComponent } from 'vue'
import { Head } from '@inertiajs/inertia-vue3';
import Modal from '@/Components/Modal.vue';
import InfoMovie from '@/Components/InfoMovie.vue';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head :title="isEvents ? __('Events') : __('Showings')" />

    <Base>
        <div class="title">
            <h3 v-if="!isEvents">{{__("List of movie showings")}}</h3>
            <h3 v-else>{{__("List of events")}}</h3>
        </div>

        <div class="filter-wrapper">
            <div class="filter">
                <span class="filter-label">{{__("Title")}}</span>
                <VueMultiselect :options="titles" v-model="filters.title">
                </VueMultiselect>
            </div>
            <div class="filter">
                <span class="filter-label">{{__("Language")}}</span>
                <VueMultiselect :options="languages" v-model="filters.language">
                </VueMultiselect>
            </div>
            <div class="filter" v-if="isEvents">
                <span class="filter-label">{{__("Type of event")}}</span>
                <VueMultiselect :options="events" v-model="filters.event">
                </VueMultiselect>
            </div>
        </div>

        <div class="wrapper-content">
            <div v-for="(movies, date) in filtered" :key="date" class="movie-showings-wrapper">
                <h3 class="date-show">{{date}}</h3>
                <div v-for="(movie, idMovie) in movies" :key="idMovie">
                    <div :class="{'show-wrapper':true, 'not-last':!isLast(movies,idMovie)}">
                        <div @click="infoMovie(movie)" class="movie-title">
                        <span>{{movie[0][$t('title')]}} - {{movie[0].language}} {{movie[0].type_room}}</span>
                        <span v-if="isEvents"> - {{movie[0][$t('type')]}}</span>
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
    </Base>
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
            filters: {title: "", language: ""},
            filtered: {},
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
            let key = show.language_id+"_"+show.room_types_id+"_"+show.movie_id;
            let date = this.dateToString(show.begin)
            if(!this.showByDatesMovies[date]){
                this.showByDatesMovies[date] = {};
            }
            if(!this.showByDatesMovies[date][key]){
                this.showByDatesMovies[date][key] = [];
            }
            this.showByDatesMovies[date][key].push(show);
        }

        this.filtered = this.showByDatesMovies;
        if(this.isEvents){
            this.filters.event = "";
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
        },
        async infoMovie(movie){
            await this.getMovie(movie[0].movie_id);
        },
        movieClose(){
            this.dataMovie = {};
        },
        async getMovie(movie){
            if(movie){
                let app = this;
                return axios.get("/api/movie/"+movie)
                    .then(function(response){
                        app.dataMovie = response.data;
                        return app.dataMovie;
                    })
                    .catch(function(response){
                    })
            }
        },
        isLast(movies,idMovie){
            let isLast = false;
            for(const [key, movie] of Object.entries(movies)){
                isLast = key == idMovie
            }
            return isLast;
        },

        filter(){
            let tmp = this.showByDatesMovies
            tmp  = this.filterByTitle(tmp)
            tmp  = this.filterByLangue(tmp)
            tmp  = this.filterByEvent(tmp)
            this.filtered = tmp;
            return tmp;
        },

        filterByTitle(showByDatesMovies){
            if(!this.filters.title){
                return showByDatesMovies;
            }
            let res = {};
            for(const [keyShow, show] of Object.entries(showByDatesMovies)){
                for(const [keyData, data] of Object.entries(show)){
                    if(data[0][this.$t('title')].includes(this.filters.title)){
                        if(!res[keyShow]){
                            res[keyShow] = {};
                        }
                        res[keyShow][keyData] = data;
                    }
                }
            }
            this.filteredByTitles = res;
            return res
        },
        filterByLangue(showByDatesMovies){
            if(!this.filters.language){
                return showByDatesMovies;
            }
            let res = {};
            for(const [keyShow, show] of Object.entries(showByDatesMovies)){
                for(const [keyData, data] of Object.entries(show)){
                    for(const [keyDetails, details] of Object.entries(data)){
                        if(details.language == this.filters.language){
                            if(!res[keyShow]){
                                res[keyShow] = {}
                            }
                            if(!res[keyShow][keyData]){
                                res[keyShow][keyData] = {}
                            }
                            if(!res[keyShow][keyData][keyDetails]){
                                res[keyShow][keyData][keyDetails] = details;
                            }
                        }
                    }
                }
            }
            return res
        },
        filterByEvent(showByDatesMovies){
            if(!this.filters.event){
                return showByDatesMovies;
            }
            let res = {};
            for(const [keyShow, show] of Object.entries(showByDatesMovies)){
                for(const [keyData, data] of Object.entries(show)){
                    for(const [keyDetails, details] of Object.entries(data)){
                        let event = details[this.$t('type')]
                        if(event == this.filters.event){
                            if(!res[keyShow]){
                                res[keyShow] = {}
                            }
                            if(!res[keyShow][keyData]){
                                res[keyShow][keyData] = {}
                            }
                            if(!res[keyShow][keyData][keyDetails]){
                                res[keyShow][keyData][keyDetails] = details;
                            }
                        }
                    }
                }
            }
            return res
        },
    },
    computed: {
        canScroll(){
            return Object.keys(this.dataMovie).length == 0;
        },
        titles(){
            let res = [];
            for(const [keyShow, show] of Object.entries(this.filtered)){
                for(const [keyData, data] of Object.entries(show)){
                    if(!res.includes(data[0][this.$t('title')])){
                        res.push(data[0][this.$t('title')]);
                    }
                }
            }
            return res;
        },
        languages(){
            let res = [];
            for(const [keyShow, show] of Object.entries(this.filtered)){
                for(const [keyData, data] of Object.entries(show)){
                    for(const [keyDetails, details] of Object.entries(data)){
                        if(keyDetails != 'title'){
                            if(!res.includes(details.language)){
                                res.push(details.language);
                            }
                        }
                    }
                }
            }
            return res
        },
        events(){
            let res = [];
            for(const [keyShow, show] of Object.entries(this.filtered)){
                for(const [keyData, data] of Object.entries(show)){
                    for(const [keyDetails, details] of Object.entries(data)){
                        if(keyDetails != 'title'){
                            let event = details[this.$t('type')]
                            if(!res.includes(event)){
                                res.push(event);
                            }
                        }
                    }
                }
            }
            return res
        },
        filterTitle(){
            return this.filters.title;
        },
        filterLanguage(){
            return this.filters.language;
        },
        filterEvent(){
            return this.filters.event ? this.filters.event : ""; //Pour la réactivité de vue
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
        filterTitle(){
            this.filter();
        },
        filterLanguage(){
            this.filter();
        },
        filterEvent(){
            this.filter();
        }
    }
})

</script>

<style scoped>
.wrapper-content {
    padding-bottom: 10px;
    margin-top: 10px;
}
.title{
    text-align: center;
}

.filter-wrapper{
    height: fit-content;
    background: #22577A;
    margin: auto;
    display: flex;
    justify-content: center;
    padding: 5px;
    flex-wrap: wrap;
    max-width: fit-content;
    width: 80%;
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
    .filter-wrapper{
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
