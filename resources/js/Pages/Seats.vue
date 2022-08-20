<script setup>
import BuyLayout from '@/Layouts/Buy.vue';
import { defineComponent } from 'vue'
import { Head } from '@inertiajs/inertia-vue3';
import Button from '@/Components/Button.vue';
import axios from 'axios';

</script>

<template>
    <Head title="Dashboard" />

    <BuyLayout :movie="movie" :show="show" :title="'Select your seats'">
        <div class="wrapper-seats">
            <span class="label-screen">{{__("Screen")}}</span>
            <hr class="screen" title="screen"/>
            <div class="row" v-for="row in seats" :key="row.index">
                <div v-for="seat in row.data" :key="seat.num_seat" @click="select(seat)" :class="{'seat' : true, 'nothing': !seat.activated, 'taken': isTaken(seat), 'selected': seat.selected}">
                    <font-awesome-icon :icon="['fa', 'couch']" v-if="seat.activated"/>
                </div>
            </div>
            <span class="info" v-if="nbSeatsSelected">{{Math.round(nbSeatsSelected * show.price *100)/100}}€</span>
            <span class="info" v-else></span>
            <Button :disabled="!canContinue" @click="createTemporaryTickets">{{__("Confirm")}}</Button>
            <div class="errors">
                <div v-for="error in errors">
                    {{error}}
                </div>
            </div>
        </div>


    </BuyLayout>
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
            seats: [],
            errors: [],
            displayMovie: false,
        }
    },

    beforeMount(){
        this.layout = JSON.parse(this.show.room.layout_json);
        this.seats = this.generateSeats();
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
        async createTemporaryTickets(){
            this.errors.length = 0;
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
                window.location.href = app.$route('payment', app.sessionCode);
                return true;
            })
            .catch(function(error){
                let res = error.response
                if(res.status == 423){
                    app.errors.push('The seats are no longer available');
                } else{
                    app.errors.push('An error occured');
                }
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
            return this.nbSeatsSelected > 0 &&  this.nbSeatsSelected <= 10;
        },
        nbSeatsSelected(){
            return this.seatsSelected.length;
        }
    },
    watch: {
        seatsSelected(){
            let message = "You cannot command more than 10 tickets at once"
            this.errors = this.errors.filter(x => x != message);
            if(this.seatsSelected.length >= 11){
                this.errors.push(message);
            }
        }
    }
})

</script>

<style scoped>
.wrapper-seats{
    display: flex;
    flex-direction: column;
    align-items: center;
    width: fit-content;
    margin: auto;
    background: #cfe4f2;
    padding: 10px;
    border-radius: 5px;
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
    text-align: center;
}

.info{
    font-family: 'Nunito-black';
    margin-top: 10px;
    color: #22577A;
    min-height: 21px;
}
</style>
