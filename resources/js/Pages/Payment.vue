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



</script>

<template>
    <Head title="Dashboard" />

    <BuyLayout :movie="movie" :show="show" :title="'Payment'">
        <div class="wrapper-payment">
            <span class="info">{{movie.title}}</span>
            <span class="info">Number of tickets: {{nbTickets}}</span>
            <span class="info">Total : {{price}}€</span>
            <div class="mx-auto w-50" ref="paypal"></div>
            <Button>Continue</Button>
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
        console.log(this.show);
        console.log(this.temporaryTickets);
        console.log(this.sessionCode);
        console.log(this.movie);
    },

    mounted(){
        const script = document.createElement("script");
        script.src ="https://www.paypal.com/sdk/js?currency=EUR&client-id=Aawzj-LDXzTPUd-AltFDeaBa-f-mXkBAAbyU5Urj3_6FYOOk7Jx46jfkOJ2WN7k9QA1R88p2UwfGCMqV";
        script.addEventListener("load", this.setLoaded);
        document.body.appendChild(script);
        console.log(this.paypalItems)
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
                        return actions.order.capture().then(function(details) {
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
        }
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
    margin-top: 10px;
    color: #22577A;
}
</style>
