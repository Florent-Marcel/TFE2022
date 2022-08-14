<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Auth.vue';
import BuyLayout from '@/Layouts/Buy.vue';
import moment from 'moment';
import { defineComponent } from 'vue'
import { Head } from '@inertiajs/inertia-vue3';
import Button from '@/Components/Button.vue';
import axios from 'axios';
import { inject } from 'vue'
import { maybeMap } from 'qs/lib/utils';
import { usePage } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'



</script>

<template>
    <Head title="Dashboard" />

    <BuyLayout :movie="movie" :show="show" :title="'Payment'">
        <div class="wrapper-payment">
            <span class="info">{{movie.title}}</span>
            <span class="info">Number of tickets: {{nbTickets}}</span>
            <span class="info">Total : {{price}}€</span>
            <div class="paypal" ref="paypal" v-show="!timeError"></div>
            <Button @click="cancel">Cancel</Button>
            <span class="info">Remaining time: {{$secondsToMinutesString(remainingTime)}}</span>
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
        time: Number,
    },

    data() {
        return {
            layout: [],
            seats: [],
            errors: [],
            displayMovie: false,
            intervalId: 0,
            passedSeconds: 0,
            timeError: false,
        }
    },

    beforeMount(){
        let app = this;
        let now = new Date(Date.now());
        let ticketCreation = new Date(this.temporaryTickets[0].created_at)
        this.intervalId = window.setInterval(function(){
            app.passedSeconds++;
        }
        , 1000);
        Inertia.on('before', (event) => {
            if(app.intervalId){
                clearInterval(app.intervalId)
            }
        })
    },

    mounted(){
        const script = document.createElement("script");
        script.src ="https://www.paypal.com/sdk/js?currency=EUR&client-id=Aawzj-LDXzTPUd-AltFDeaBa-f-mXkBAAbyU5Urj3_6FYOOk7Jx46jfkOJ2WN7k9QA1R88p2UwfGCMqV";
        script.addEventListener("load", this.setLoaded);
        document.body.appendChild(script);
    },

    methods:{
        setLoaded(resp) {
            let app = this;
            this.loaded = true;
            window.paypal
                .Buttons({
                    createOrder: (data, actions) => {
                        return actions.order.create({
                            purchase_units: [{
                                description: app.nbTickets +" tickets",
                                amount: {
                                    currency_code: "EUR",
                                    value: app.price,
                                     breakdown: {
                                        item_total: {
                                            currency_code: "EUR",
                                            value: app.price
                                        }
                                    }
                                },
                                items: app.paypalItems
                            }]
                        });
                    },
                    onApprove: async (data, actions, resp) => {
                        // This function captures the funds from the transaction.
                        return await actions.order.capture().then( async function(details) {
                            // This function shows a transaction success message to your buyer.
                            console.log(details)
                            console.log(details.purchase_units[0].payments.captures[0].id)
                            alert('Transaction completed by ' + details.payer.name.given_name);
                        })
                    },
                    onError: err => {
                        console.log(err);
                    }
                })
            .render(this.$refs.paypal);
        },
        async createTickets(){

        },
        async deleteCurrentTempSeats(){
            axios.post('/api/deleteUserLastTemporaryTickets')
            .then(function(response){
                console.log(response)
                return response.data;
            })
            .catch(function(error){
                console.log(error)
                return false
            })
        },

        async cancel(timeOut=1){
            await this.deleteCurrentTempSeats();
            setTimeout(() => {window.history.back()}, timeOut);
        }
    },
    computed: {
        price(){
            return this.show.price * this.nbTickets;
        },
        nbTickets(){
            return this.temporaryTickets.length;
        },
        paypalItems(){
            let res = [];
            let i = 1;
            for(let ticket of this.temporaryTickets){
                res.push({
                    name: "Ticket " +ticket.id,
                    sku: "Tic-"+ticket.id,
                    description: "Seat number " + ticket.num_seat,
                    unit_amount: {
                        currency_code: "EUR",
                        value: this.show.price,
                    },
                    quantity: 1
                });
            }
            return res;
        },
        remainingTime(){
            let ticketTime = this.time * -1;
            let res = ticketTime - this.passedSeconds
            if(res < 0){
                res = 0;
                if(!this.timeError){
                    this.errors.push("Your token is no longer valid. You will be redirected in 5 seconds");
                    this.timeError = true;
                    this.cancel(5000);
                }
            }
            return res;
        },
    },
    watch: {
    }
})

</script>

<style scoped>
.wrapper-payment{
    display: flex;
    flex-direction: column;
    align-items: center;
    width: fit-content;
    min-height: 100%;
    background: #cfe4f2;
    padding: 10px;
    border-radius: 5px;
}

button{
    color:white;
    background-color: #ff906e;
    margin-top: 20px;
}

button:hover{
    background-color: #ffa78c;
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
}

.paypal{
    margin-top: 15px;
    position: relative;
    z-index: 1;
}

.errors{
    max-width: 200px;
}
</style>