<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Auth.vue';
import BuyLayout from '@/Layouts/Buy.vue';

import { defineComponent } from 'vue'
import { Head } from '@inertiajs/inertia-vue3';
import Button from '@/Components/Button.vue';
import axios from 'axios';
import { Link } from '@inertiajs/inertia-vue3';

</script>

<template>
    <Head title="Dashboard" />

    <BuyLayout :movie="movie" :show="show" title="Here are your tickets">
        <div class="tickets-wrapper">
            <div v-for="ticket in tickets" :key="ticket.id" class="ticket">
                <span class="info">{{__("Seat")}} {{ticket.num_seat}}: </span>
                <a :href="route('download.ticket', ticket.id)"><font-awesome-icon class="pdf" icon="fa-solid fa-file-pdf" size="xl"/></a>
            </div>
        </div>
    </BuyLayout>
</template>

<script>

export default defineComponent({
    props:{
        show: Object,
        tickets: Object,
        movie: Object,
    },

    data() {
        return {
        }
    },

    beforeMount(){
    },

    methods:{
    },
    computed: {
    },
    watch: {
    }
})

</script>

<style scoped>
.tickets-wrapper{
    display: flex;
    flex-direction: column;
    align-items: center;
    width: fit-content;
    margin: auto;
    background: #cfe4f2;
    padding: 10px;
    border-radius: 5px;
}

button{
    color:white;
    background-color: #6A96B0;
    margin-top: 20px;
}

.errors *{
    color: red;
    font-family: 'Nunito-black';
    margin-top: 10px;
    text-align: center;
}

.info{
    font-family: 'Nunito-black';
    color: #22577A;
}

.pdf{
    margin: 3px;
    color: #c10000;
}

.pdf:hover{
    filter:brightness(120%);
}

.ticket{
    display: flex;
    align-items: center;
}

</style>
