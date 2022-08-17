<script setup>
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="menu">
        <div class="elem-menu">
            <Link :class="{'actif' : route().current() == 'home'}" :href="route('home')">{{__("Home")}}</Link>
            <div class="actif-bar" v-if="route().current() == 'home'"></div>
        </div>
        <div class="elem-menu">
            <Link :class="{'actif' : route().current() == 'movies'}" :href="route('movies')">{{__("Movies")}}</Link>
            <div class="actif-bar" v-if="route().current() == 'movies'"></div>
        </div>
        <div class="elem-menu">
            <Link :class="{'actif' : route().current() == 'showings'}" :href="route('showings')">{{__("Showings")}}</Link>
            <div class="actif-bar" v-if="route().current() == 'showings'"></div>
        </div>
        <div class="elem-menu">
            <Link :class="{'actif' : route().current() == 'events'}" :href="route('events')">{{__("Events")}}</Link>
            <div class="actif-bar" v-if="route().current() == 'events'"></div>
        </div>
    </div>
</template>


<script>

export default defineComponent({
    props:{

    },

    data() {
        return {
            user: this.$page.props.user
        }
    },

    mounted(){
        console.log(window.location.origin)
    },

    methods: {
        goToAdmin(){
            if(this.user.is_admin){
                let url = window.location.origin+'/admin';
                window.location = url;
            }
        }
    }
})

</script>

<style scoped>
.menu{
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    align-content: center;
    background: #22577A;
    color: #F4F3F7;
    margin-bottom: 10px;
}

.menu .elem-menu{
    padding-left: 5px;
    padding-right: 5px;
    height: 35px;
    display: flex;
    align-items: center;
    position: relative;
    flex-wrap: wrap;
    justify-content: center;
    cursor: pointer;
}

.menu .elem-menu a {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
}
.menu .elem-menu:hover{
    filter:brightness(150%);
}

.menu .elem-menu .actif{
    font-family: 'Nunito-black';
}

.elem-menu .actif-bar {
    width: 100%;
    background: #DDDAE7;
    height: 5px;
    position: absolute;
    bottom: 0px;
}
</style>
