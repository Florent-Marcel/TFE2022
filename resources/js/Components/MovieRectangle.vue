<script setup>
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/inertia-vue3';
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
</script>

<template>
    <div class="movie-title">
        <span>{{movie[$t('title')]}}</span>
    </div>
    <div class="movie-poster">
        <img v-if="movie.poster_url && movie.canLoadIMG" :src="movie.poster_url" @load="loadNext()">
        <img v-else>
    </div>
    <div class="movie-dates" v-if="findExtremitySceance(movie.showings, true) != findExtremitySceance(movie.showings, false)">
        {{__("From")}} {{$dateToLittleString(findExtremitySceance(movie.showings, true))}} {{__("to")}} {{$dateToLittleString(findExtremitySceance(movie.showings, false))}}
    </div>
    <div class="movie-dates" v-else>
        {{$dateToLittleString(findExtremitySceance(movie.showings, true))}}
    </div>
</template>


<script>

export default defineComponent({
    emits: ["loadnext"],
    props: {
        movie: Object,
    },
    data(){
        return {

        }
    },
    methods: {
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
        loadNext(){
            this.$emit('loadnext');
        }
    },
})

</script>

<style scoped>

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

.movie-poster img{
    width: 215px;
    height: 323px;
}

.movie-dates {
    height: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
