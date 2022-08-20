<script setup>
import { ref } from 'vue';
import Base from '@/Layouts/Base.vue';
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import BreezeNavLink from '@/Components/NavLink.vue';
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { defineComponent } from 'vue'
import Header from '@/Components/HeaderAuth.vue'
import Menu from '@/Components/Menu.vue'
import InfoMovie from '@/Components/InfoMovie.vue';
import Modal from '@/Components/Modal.vue';

const showingNavigationDropdown = ref(false);

const props = defineProps({
title: {
    type: String,
},
show: {
    type: Object,
},
movie: {
    type: Object,
},
});

const movieClose = () =>{
    displayMovie.value = false;
};

const displayMovie = ref(false);
</script>

<script>

</script>

<template>
    <Base>
        <div class="title">
            <h3>{{__(title)}}</h3>
        </div>
        <div class="wrapper">
            <slot />
            <div class="wrapper-movie">
                <img class="movie-poster" :src="movie.poster_url" @click="displayMovie = true;" title="Display details"/>
                <span class="info-seance movie-title" @click="displayMovie = true;" title="Display details">{{movie[$t('title')]}}</span>
                <div class="info-seance">
                    <span>{{$dateToLittleString(show.begin)}} - {{$dateToHourString(show.begin)}}</span>
                    <span>{{show.language.language}}</span>
                    <span>{{show.room.room_type.type}}</span>
                    <span>{{show.price}}€ {{__("per ticket")}}</span>
                </div>
            </div>
        </div>
        <Modal v-if="displayMovie" @close="movieClose">
            <InfoMovie :movie="movie" :idShow="show.id"></InfoMovie>
        </Modal>
    </Base>
</template>


<style>
.title{
    text-align: center;
}

.wrapper{
    background-color: #22577A;
    width: fit-content;
    margin: auto;
    padding: 10px;
    display: flex;
}

.wrapper-movie{
    display: flex;
    margin-left: 10px;
    flex-direction: column;
    align-content: center;
    align-items: center;
    color: white;
    max-width: 200px;

}

.wrapper-movie img{
    width: 200px;
    height: 300px;
    min-width: 200px;
    min-height: 300px;
}

.info-seance, .info-seance *{
    text-align: center;
    font-family: 'Nunito-black';
    display: flex;
    flex-direction: column;
    align-items: center;
}

.info-seance.movie-title, .movie-poster{
    cursor: pointer;
}

.info-seance.movie-title{
    margin-bottom: 10px;
}

.info-seance.movie-title:hover, .movie-poster:hover{
    filter:brightness(120%);
}
</style>






