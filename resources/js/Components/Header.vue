<script setup>
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/inertia-vue3';
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
</script>

<template>
    <div class="header">
        <Link class="logo-wrapper" :href="route('home')">
            Cinemar
        </Link>

        <div class="buttons-header-wrapper">
            <BreezeDropdown align="middle" width="48" :contentClasses="['py-1', 'bg-slate-200']">
                <template #trigger>
                    <span class="inline-flex rounded-md">
                        <button type="button" class="inline-flex items-center border border-transparent text-sm leading-4 font-medium rounded-md hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <font-awesome-icon icon="fa-solid fa-user" />{{ user ? user.firstname : __('Visitor') }}
                        </button>
                    </span>
                </template>
                <template #content>
                    <BreezeDropdownLink v-if="user" :href="route('profil')" method="get" as="button" class="dropdown">
                        {{__('My profil')}}
                    </BreezeDropdownLink>
                    <BreezeDropdownLink v-if="user" :href="route('logout')" method="post" as="button" class="dropdown">
                        {{__('Log Out')}}
                    </BreezeDropdownLink>
                    <BreezeDropdownLink v-else :href="route('login')" method="get" as="button" class="dropdown">
                        {{__('Login')}}
                    </BreezeDropdownLink>
                </template>
            </BreezeDropdown>
            <Link :href="route('lang.change', 'fr')" :class="{'hover:text-gray-700' : true, 'selected-lang' : lang=='fr'}">FR</Link>
            <Link :href="route('lang.change', 'en')" :class="{'hover:text-gray-700' : true, 'selected-lang' : lang=='en'}">EN</Link>
        </div>
    </div>
</template>


<script>

export default defineComponent({
    props:{
    },
    data() {
        return {
            user: this.$page.props.user,
            lang: this.$page.props.locale,
        }
    },
    mounted(){
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

.buttons-header-wrapper *:not(.dropdown){
    margin-left: 5px;
}

.buttons-header-wrapper {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
}

.buttons-header-wrapper .fa-user{
    margin-right: 10px;
}

.selected-lang{
    color: rgb(75 85 99);
}
</style>
