<script setup>
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="header">
        <div class="logo-wrapper">
            LOGO
        </div>
        <div class="buttons-header-wrapper">
            <font-awesome-icon icon="fa-solid fa-user" />
            <Link :href="route('lang.change', 'fr')">FR</Link>
            <Link :href="route('lang.change', 'en')">EN</Link>
        </div>
    </div>
</template>


<script>

export default defineComponent({
    props:{
    }
})

</script>

<style scoped>
.header{
    height: 23px;
    background: #DDDAE7;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    align-content: center;
    padding: 0px 10px 0px 10px;
}

.header * {
    font-family: 'Nunito-black';
}

.buttons-header-wrapper *{
    margin-left: 5px;
}

.buttons-header-wrapper .fa-user{
    margin-right: 10px;
}
</style>
