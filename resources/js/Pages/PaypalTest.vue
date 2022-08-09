<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Auth.vue';
import { defineComponent } from 'vue'
import { Head } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <div class="mx-auto w-50" ref="paypal"></div>
    </BreezeAuthenticatedLayout>
</template>


<script>

export default defineComponent({
    props:{

    },

    data() {
        return{
            loaded: false,
            showpaypal: false,
            loadding: false,
            paidFor: false,
            price: 3.90,
        }
    },
    mounted(){
        const script = document.createElement("script");
        script.src ="https://www.paypal.com/sdk/js?client-id=Aawzj-LDXzTPUd-AltFDeaBa-f-mXkBAAbyU5Urj3_6FYOOk7Jx46jfkOJ2WN7k9QA1R88p2UwfGCMqV";
        script.addEventListener("load", this.setLoaded);
        document.body.appendChild(script);
    },
    methods:{
        setLoaded: function(resp) {
        this.loaded = true;
        window.paypal
          .Buttons({
            createOrder: (data, actions) => {
              return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '0.01'
                        }
                    }]
                });
            },
            onApprove: async (data, actions, resp) => {
                // This function captures the funds from the transaction.
                return actions.order.capture().then(function(details) {
                    // This function shows a transaction success message to your buyer.
                    console.log(details)
                    alert('Transaction completed by ' + details.payer.name.given_name);
                })
            },
            onError: err => {
              console.log(err);
            }
          })
          .render(this.$refs.paypal);
    },
    },
    computed: {

    },
    watch: {
    }
})

</script>

<style scoped>
.title{
    text-align: center;
}

.filter-wrapper{
    height: fit-content;
    width: fit-content;
    background: #22577A;
    margin: auto;
    display: flex;
    justify-content: center;
    padding: 5px;
}

.filter-wrapper .filter{
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 300px;
    margin: 5px;
}

.filter-wrapper .filter span{
    font-weight: bold;
    color: #F4F3F7;
}

.movie-showings-wrapper {
    width: 80%;
    margin: auto;
    padding: 5px;
    background: #22577A;
    color: #F4F3F7;
    margin-bottom: 15px;
    display: flex;
    flex-direction: column;
}

.movie-rectangle:hover {
    filter:brightness(120%);
}

.movie-poster img{
    width: 215px;
    height: 323px;
}

.movie-title {
    font-weight: bold;
    width: fit-content;
    cursor: pointer;
}

.movie-title:hover{
    filter:brightness(120%);
}

.movie-title span {
    font-family: 'Nunito-black';
    text-align: center;
}

.movie-dates {
    height: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.movie-wrapper {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
    width: 80%;
    margin: auto;
}

.time-wrapper{
    display: flex;
    margin: 3px;
}

.show-wrapper{
    display: flex;
    justify-content: space-between;
}

.time-case{
    margin-left: 5px;
    background-color: #6995B2;
    border-radius: 5px;
    padding: 3px;
    user-select: none;
    cursor: pointer;
}

.time-case:hover{
    filter:brightness(120%);
}

.date-show{
    text-align: center;
}
</style>
