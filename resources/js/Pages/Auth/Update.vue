<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import Auth from '@/Layouts/Auth.vue';
import { usePage } from '@inertiajs/inertia-vue3'

const user = usePage().props.value.auth.user

const form = useForm({
    email: user.email,
    firstname: user.firstname,
    lastname: user.lastname,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Auth>
        <Head title="update" />
        <div class="update-wrapper">
            <div class="update">
                <h3 class="title">{{__("Edit your user data")}}</h3>
                <BreezeValidationErrors class="mb-4 errors" />

                <form @submit.prevent="submit">
                    <div class="mt-4">
                        <BreezeLabel for="email" value="Email" />
                        <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />
                    </div>
                    <div class="mt-4">
                        <BreezeLabel for="firstname" value="Firstname" />
                        <BreezeInput id="firstname" type="text" class="mt-1 block w-full" v-model="form.firstname" required autocomplete="firstname" />
                    </div>
                    <div class="mt-4">
                        <BreezeLabel for="lastname" value="Lastname" />
                        <BreezeInput id="lastname" type="text" class="mt-1 block w-full" v-model="form.lastname" required autocomplete="lastname" />
                    </div>
                    <div class="mt-4">
                        <BreezeLabel for="password" value="Password" />
                        <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
                    </div>
                    <div class="mt-4">
                        <BreezeLabel for="password_confirmation" value="Confirm Password" />
                        <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            {{__("Update")}}
                        </BreezeButton>
                    </div>
                </form>
            </div>
        </div>
    </Auth>
</template>


<style scoped>
    label{
        color: white;
    }
    .update-wrapper{
        height: calc(100% - var(--header-margin));
        width: 100%;
        display: flex;
    }
    .update{
        width: 500px;
        height: fit-content;
        margin: auto;
        margin-top: auto;
        border: 1px rgb(185, 185, 185) solid;
        border-radius: 10px;
        padding: 10px;
        background-color: #22577A;
        vertical-align: middle;
    }
    .title{
        text-align: center;
        color: #F4F3F7;
    }
</style>
