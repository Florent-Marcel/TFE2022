<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Auth.vue';
import Modal from '@/Components/Modal.vue';
import InfoMovie from '@/Components/InfoMovie.vue';
import { defineComponent } from 'vue'
import { Head } from '@inertiajs/inertia-vue3';
import Button from '@/Components/Button.vue';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <div class="title">
            <h3>{{__("My profil")}}</h3>
        </div>

        <div class="wrapper-profil">
            <div class="info-wrapper">
                <div class="info">
                    <span class="label-info">Email</span> <span>{{user.email}}</span>
                </div>
                <div class="info">
                    <span class="label-info">{{__("Firstname")}}</span> <span>{{user.firstname}}</span>
                </div>
                <div class="info">
                    <span class="label-info">{{__("Lastname")}}</span> <span>{{user.lastname}}</span>
                </div>
                <Link :href="route('update')" class="link-edit">
                    <Button>{{__("Edit")}}</Button>
                </Link>
            </div>

            <div class="tickets-wrapper" v-if="hasTickets">
                <h4>{{__("My tickets")}}</h4>
                <div class="tickets">
                    <div class="ticket-show" v-for="show in ticketsByShow" :key="show">
                        <div class="date-ticket">
                            {{$dateToString(show[0].showing.begin)}} {{__('at')}}
                            {{$dateToHourString(show[0].showing.begin)}}
                        </div>
                        <div class="movie-title">{{show[0].showing.movie[$t('title')]}}</div>
                        <div class="info-sup-show">
                        {{show[0].showing.language.language}} - 
                        {{show[0].showing.room.room_type.type}} - {{show[0].showing.showing_type[$t('type')]}}</div>
                        <div class="list-tickets">
                            <div class="ticket" v-for="ticket in show" :key="ticket.id">
                                <span class="info">{{__("Seat")}} {{ticket.num_seat}}</span>
                                <a :href="route('download.ticket', ticket.id)"><font-awesome-icon class="pdf" icon="fa-solid fa-file-pdf" size="xl"/></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="tickets-wrapper">
                <h4>{{__('You don\'t have any tickets')}}</h4>
            </div>
        </div>

        

    </BreezeAuthenticatedLayout>
</template>

<script>

export default defineComponent({
    props:{
        user: Object,
        tickets: Array,
    },

    data() {
        return {
            ticketsByShow: {},
        }
    },

    beforeMount(){
        this.init();
    },

    methods:{
        init(){
            this.tickets.sort(function(a, b){
                if(Date.parse(a.showing.begin) < Date.parse(b.showing.begin)){
                    return -1;
                }
                if(Date.parse(a.showing.begin) > Date.parse(b.showing.begin)){
                    return 1;
                }
                return 0;
            })
            for(let ticket of this.tickets){
                let key = `${Date.parse(ticket.showing.begin)}_${ticket.showing.id}`
                if(!this.ticketsByShow[key]){
                    this.ticketsByShow[key] = [];
                }
                this.ticketsByShow[key].push(ticket);
            }
        }
    },
    computed: {
        hasTickets(){
            return this.tickets.length > 0;
        }
    },
    watch: {
        
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

.wrapper-profil {
    background: #22577A;
    width: fit-content;
    max-width: 400px;
    height: fit-content;
    color: #F4F3F7;
    margin: auto;
    padding: 10px;
}

.label-info{
    font-family: 'Nunito-black';
    margin-top: 5px;
}

.info-wrapper, .info{
    display: flex;
    flex-direction: column;
}

.info-wrapper{
    border-bottom: 1px #cfe4f2 solid;
}

button{
    color:white;
    background-color: #6A96B0;
    text-align: center;
    width: fit-content;
    align-self: center;
}

.link-edit{
    width: fit-content;
    align-self: center;
    padding: 0px;
    position: relative;
    margin: 20px;
}

.tickets-wrapper{
    padding-top: 20px;
}

.tickets-wrapper h4{
    text-align: center;
}

.pdf{
    margin: 3px;
}

.pdf:hover{
    filter:brightness(120%);
}

.date-ticket{
    margin-top: 10px;
}

.date-ticket, .movie-title, .info-sup-show{
    text-align: center;
}

.date-ticket, .movie-title{
    font-family: 'Nunito-black';
}

.list-tickets{
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: space-evenly;
    margin: 10px;
}

.list-tickets .ticket{
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 5px;
}
</style>
