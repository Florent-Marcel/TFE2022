<script setup>
import { ref } from 'vue';
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import BreezeNavLink from '@/Components/NavLink.vue';
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { defineComponent } from 'vue'
import Header from '@/Components/HeaderAuth.vue'
import Menu from '@/Components/Menu.vue'

const showingNavigationDropdown = ref(false);
</script>

<template>
    <Header></Header>
    <Menu></Menu>
    <main class="main">
        <slot />
    </main>
</template>


<style>
@font-face {
    font-family: "Nunito";
    src: url('/fonts/NunitoSans-Regular.ttf');
}

@font-face {
    font-family: "Nunito-black";
    src: url("/fonts/NunitoSans-Black.ttf");
}

html {
    background: #F4F3F7;
}

html * {
    font-family: "Nunito";
    font-size: 14px;
}

body {
    margin: 0px 0px 8px 0px;
}

a {
    text-decoration: none;
    color: inherit;
}

h3{
    font-family: 'Nunito-black';
    font-size: 19px;
}

h4{
    font-family: 'Nunito-black';
    font-size: 16px;
}
</style>

