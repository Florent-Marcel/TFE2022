<script setup>
import moment from 'moment';
import { defineComponent } from 'vue'
</script>

<template>
    <div v-if="movie" class="movie-component">
        <div class="poster-section">
            <div class="movie-poster">
                <img :src="movie.poster_url"/>
            </div>
            <div class="data-movie-right">
                <div class="title">
                    <h3>{{movie.title}}</h3>
                </div>
                <div class="genre-list">
                    <div v-for="genre in movie.types" :key="genre.id">
                        <div class="genre">
                            {{genre.type}}
                        </div>
                    </div>
                </div>
                <h4 class="sub-title">Overview</h4>
                <div class="overview info-movie">
                    {{movie.synopsis}}
                </div>
                <h4 class="sub-title">Duration</h4>
                <div class="info-movie">
                    {{minutesToString(movie.duration)}}
                </div>
                <h4 class="sub-title">Release date</h4>
                <div class="info-movie">
                    {{dateToString(movie.date_release)}}
                </div>
                <h4 class="sub-title">Rating</h4>
                <div class="info-movie">
                    {{doubleToString(movie.rating)}} / 10
                </div>
            </div>
        </div>
        <div class="under-section">
            <h3 class="sub-title">Showings</h3>
            <div class="showings-wrapper">
                <div class="showing-type" v-for="showingType in showingTypes" :key="showingType">
                    <h4 class="sub-title">
                        {{showingType.language}} - {{showingType.type}}
                    </h4>
                    <div class="showing-list">
                        <div class="showing" v-for="show in showingType.showings" :key="show.id">
                            <div>{{dateToLittleString(show.begin)}}</div>
                            <div>{{dateToHourString(show.begin)}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="sub-title">personalities</h3>
            <div class="personalities">
                <div class="personality" v-for="perso in movie.personalities_professions_movies" :key="perso.id">
                    <img v-if="perso.canLoadIMG" :src="perso.personality.profile_url" @load="loadNext"/>
                    <img v-else/>
                    <div class="personality-name">{{perso.personality.name}}</div>
                    <div class="personality-profession">{{perso.profession.profession}}</div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

export default defineComponent({
    props:{
        movie: {
            type: Object,
        },
    },
    data() {
        return {
            loadIndex: 0,
            maxImgLoadSimultaneous: 19,
        }
    },
    beforeMount(){
        for(let perso of this.movie.personalities_professions_movies){
            perso.canLoadIMG = false
            if(this.loadIndex < this.maxImgLoadSimultaneous){
                perso.canLoadIMG = true;
                this.loadIndex++;
            }
        }
        console.log(this.movie.personalities_professions_movies);
    },
    methods: {
        minutesToString(minutes){
            let nbHours = Math.floor(minutes /60);
            let nbMinutes = minutes % 60;
            return `${nbHours}h${nbMinutes}`;
        },
        dateToString(date){
            moment.locale('fr');
            return moment(date).format('LL');
        },
        dateToLittleString(date){
            moment.locale('fr');
            return moment(date).format('L');
        },
        dateToHourString(date){
            moment.locale('fr');
            return moment(date).format('LT');
        },
        doubleToString(num){
            num = parseFloat(num);
            return Math.round((num + Number.EPSILON) * 100) / 100
        },
        loadNext(){
            if(this.movie.personalities_professions_movies[this.loadIndex]){
                this.movie.personalities_professions_movies[this.loadIndex].canLoadIMG = true;
            }
            this.loadIndex++;
        },
    },
    computed: {
        showingTypes(){
            let res = {}
            if(!this.movie){
                return res;
            }
            for(let show of this.movie.showings){
                let key = show.language.id+"_"+show.room.room_type.id;
                if(!res[key]){
                    res[key] = {};
                    res[key].language = show.language.language;
                    res[key].type = show.room.room_type.type;
                    res[key].showings = [];
                }
                res[key].showings.push(show);
            }
            console.log(res)
            return res;
        }
    }
})

</script>

<style scoped>
.movie-component{
    padding: 5px;
}

.movie-poster img{
    width: 240px;
    height: 360px;
    min-width: 240px;
    min-height: 360px;
}

.poster-section{
    display: flex;
}

.poster-section > *{
    margin: 5px;
}

.genre-list{
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    align-content: center;
    align-items: center;
    margin-bottom: 5px;
}

.genre-list .genre{
    background-color: #CFE4F1;
    color: #235878;
    font-family: 'Nunito-black';
    width: fit-content;
    height: fit-content;
    border-radius: 10px;
    padding: 3px;
    margin-right: 3px;
}

.modal .poster-section .info-movie{
    text-align: justify;
}

.sub-title{
    margin-top: 10px;
}

.showings-wrapper .showing{
    background-color: #6A96B0;
    width: 100px;
    height: 50px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-around;
    margin-right: 10px;
    border-radius: 15px;
}

.showings-wrapper .showing-list{
    display: flex;
    flex-direction: row;
    align-items: center;
    align-content: center;
    flex-wrap: wrap;
}

.personality img{
    height: 160px;
}

.personality{
    width: 110px;
    height: 250px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    align-content: center;
    flex-wrap: wrap;
    text-align: center;
}

.personality-name {
    font-weight: bold;
}

.personality-profession {
    font-style: italic;
}

.personalities {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    align-items: center;
    align-content: center;
}
</style>