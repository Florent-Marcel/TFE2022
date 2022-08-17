<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import Auth from '@/Layouts/Auth.vue';
import { usePage } from '@inertiajs/inertia-vue3'

defineProps({
    status: String,
});

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('profil.password.edit'), {
        onFinish: () => {
            form.reset('current_password', 'password', 'password_confirmation'); //Don't always work
            form.current_password = "";
            form.password = "";
            form.password_confirmation = "";
            },
    });
};
</script>

<template>
    <Auth>
        <Head :title="__('Edit password')" />
        <div class="update-wrapper">
            <div class="update">
                <h3 class="title">{{__("Edit your password")}}</h3>
                <BreezeValidationErrors class="mb-4 errors" />

                <div v-if="status" class="mb-4 font-bold text-sm text-green-600">
                    {{ status }}
                </div>

                <form @submit.prevent="submit">
                    <div class="mt-4">
                        <BreezeLabel for="current_password" value="Current password" />
                        <BreezeInput id="current_password" type="password" class="mt-1 block w-full" v-model="form.current_password" required />
                    </div>
                    <div class="mt-4">
                        <BreezeLabel for="password" value="New password" />
                        <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
                    </div>
                    <div class="mt-4">
                        <BreezeLabel for="password_confirmation" value="Confirm Password" />
                        <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required />
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <Link :href="route('profil')" class="underline text-sm text-white hover:text-gray-300 mx-2">
                            {{__("Cancel")}}
                        </Link>
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
    label, span{
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
