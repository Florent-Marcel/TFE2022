<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Auth.vue';
import InfoMovie from '@/Components/InfoMovie.vue';
import { defineComponent } from 'vue'
import { Head } from '@inertiajs/inertia-vue3';
import Button from '@/Components/Button.vue';
import axios from 'axios';
import Modal from '@/Components/Modal.vue';
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <div class="title">
            <h3>Select your seats</h3>
        </div>

        <div class="wrapper" v-if="loaded">
            <span class="info">{{movie.title}}</span>
            <span class="info">{{show.price}}€</span>
            <span class="label-screen">Screen</span>
            <hr class="screen" title="screen"/>
            <div class="row" v-for="row in seats" :key="row.index">
                <div v-for="seat in row.data" :key="seat.num_seat" @click="select(seat)" :class="{'seat' : true, 'nothing': !seat.activated, 'taken': isTaken(seat), 'selected': seat.selected}">
                    <font-awesome-icon :icon="['fa', 'couch']" v-if="seat.activated"/>
                </div>
            </div>
            <Button :disabled="!canContinue" @click="createTemporaryTickets">Continue</Button>
            <div class="info details" @click="displayMovie = true;">Display details</div>
            <div class="errors">
                <div v-for="error in errors">
                    {{error}}
                </div>
            </div>
        </div>
        <Modal v-if="displayMovie" @close="movieClose">
            <InfoMovie :movie="movie" :idShow="show.id"></InfoMovie>
        </Modal>


    </BreezeAuthenticatedLayout>
</template>

<script>

export default defineComponent({
    props:{
        show: Object,
        temporaryTickets: Object,
        sessionCode: String,
        movie: Object,
    },

    data() {
        return {
            layout: [],
            loaded: false,
            seats: [],
            errors: [],
            displayMovie: false,
        }
    },

    beforeMount(){
        this.layout = JSON.parse(this.show.room.layout_json);
        this.seats = this.generateSeats();
        this.loaded = true;
    },

    methods:{
        calcIndex(nRow, i){
            return ((nRow)*this.show.room.max_places_row) +i;
        },
        isTaken(nRow, i){

        },
        isSeat(seat){
            return seat.activated
        },
        generateSeats(){
            let res = [];
            for(let row=0; row<this.show.room.nb_rows; row++){
                res[row] = {};
                res[row]['index'] = row;
                res[row]['data'] = [];
                for(let seat=1; seat<=this.show.room.max_places_row; seat++){
                    res[row].data[seat-1] = {...this.layout[this.calcIndex(row, seat)]};
                }
            }
            return res;
        },
        select(seat){
            if(!this.isTaken(seat) && seat.activated){
                seat.selected = !seat.selected;
            }
        },
        isTaken(seat){
            return this.seatsTaken.includes(seat.num_seat) || this.temporaryTickets.find(x => x.num_seat == seat.num_seat);
        },
        movieClose(){
            this.displayMovie = false;
        },
        async createTemporaryTickets(){
            let app = this;
            return await axios.post("/api/createTemporaryTickets",
            {
                id: this.show.id,
                code: this.sessionCode,
                seats: this.seatsSelected.map(x => x.num_seat),
            })
            .then(function(response){
                let res = response.data ? true : false;
                if(!res){
                    thappis.errors.push('An error occured');
                    return false;
                }
                return true;
            })
            .catch(function(error){
                let res = error.response
                if(res.status = 423){
                    app.errors.push('The seats are no longer available');
                } else{
                    app.errors.push('An error occured');
                }
                console.log(error)
                return false;
            })
        }
    },
    computed: {
        seatsSelected(){
            let res = [];
            for(let row of this.seats){
                for(let seat of row.data){
                    if(seat.selected){
                        res.push(seat);
                    }
                }
            }
            return res;
        },
        jsonSeatsSelected(){
            return JSON.stringify(this.seatsSelected.map(x => x.num_seat))
        },
        seatsTaken(){
            let res = [];
            for(let ticket of this.show.tickets){
                if(!ticket.is_blocked){
                    res.push(ticket.num_seat);
                }
            }
            return res;
        },
        canContinue(){
            return this.seatsSelected.length > 0;
        }
    },
    watch: {

    }
})

</script>

<style scoped>

.wrapper{
    display: flex;
    flex-direction: column;
    align-items: center;
    width: fit-content;
    margin: auto;
    background: #cfe4f2;
    padding: 10px;
    border-radius: 5px;
}

.title{
    text-align: center;
}

.seat{
    margin: 1px;
    color: #c10000;
    width: 16px;
    height: 24px;
}

.seat.selected{
    color: #fd4a4a;
}

.seat.taken{
    color: #9c9c9c;
}

.seat:not(.nothing, .taken){
    cursor: pointer;
}

.row{
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: center;
}

.screen{
    color: black;
    background-color: black;
    width: 80%;
    height: 2px;
    margin-bottom: 50px;
}

.label-screen{
    margin-top: 20px;
    font-family: 'Nunito-black';
    color: #22577A;
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
}

.details{
    cursor: pointer;
}

.info{
    font-family: 'Nunito-black';
    margin-top: 10px;
    color: #22577A;
}
</style>
