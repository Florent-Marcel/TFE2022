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
    <div class="header-wrapper">
        <Header></Header>
        <Menu></Menu>
    </div>
    <main class="main">
        <slot  />
    </main>
</template>


<style>
:root{
    --header-margin: 80px;
}
@font-face {
    font-family: "Nunito";
    src: url('/fonts/NunitoSans-Regular.ttf');
}

@font-face {
    font-family: "Nunito-black";
    src: url("/fonts/NunitoSans-Black.ttf");
}

.header-wrapper{
    position: fixed;
    top: 0px;
    width: 100%;
    z-index: 10;
}


html {
    background: #F4F3F7;
}

html * {
    font-family: "Nunito";
    font-size: 14px;
}

body {
    height: calc(100% - var(--header-margin));
    max-height: calc(100% - var(--header-margin));
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

#app{
    height: 100%;
}

html, body{
    height: 100%;
}

body{
    position: relative;
}

.content{

}

.main{
    height: 100%;
    margin-top: 80px;
}

::-webkit-scrollbar {
  width: 10px;
  border-radius: 5px;
  z-index: 5;
}

::-webkit-scrollbar-track {
  background: #6995B2;
  z-index: 5;
}

::-webkit-scrollbar-thumb {
  background: #AFD2E9;
  border-radius: 10px;
  z-index: 5;
}

::-webkit-scrollbar-thumb:hover {
  background: #CFE4F2;
  z-index: 5;
}
</style>

