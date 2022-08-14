<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import Auth from '@/Layouts/Auth.vue';

const form = useForm({
    email: '',
    firstname: '',
    lastname: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Auth>
        <Head title="Register" />
        <div class="register-wrapper">
            <div class="register">
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
                        <Link :href="route('login')" class="underline text-sm hover:text-gray-900 text-white">
                            Already registered?
                        </Link>
                        <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Register
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
    .register-wrapper{
        height: calc(100% - var(--header-margin));
        width: 100%;
        display: flex;
    }
    .register{
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
</style>
