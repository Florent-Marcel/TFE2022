<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import Base from '@/Layouts/Base.vue';

const props = defineProps({
    canResetPassword: Boolean,
    status: String,
    error: String,
    canConnect: Boolean,
    isAdmin: Boolean,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
    tokenAdmin: '',
});

const submit = () => {
    form.post(route('login'), {
            onFinish: () => form.reset('password', 'tokenAdmin'),
    });
};
</script>

<template>
    <Base>
        <Head title="Log in" />
        <div class="login-wrapper">
            <div class="login">
                <h3 class="title">{{__("Login")}}</h3>
                <BreezeValidationErrors class="mb-4" />

                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                    {{ status }}
                </div>
                <div v-if="error" class="mb-4 font-medium text-sm text-red-600">
                    {{ error }}
                </div>

                <form @submit.prevent="submit">
                    <div>
                        <BreezeLabel for="email" value="Email" />
                        <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username" />
                    </div>

                    <div class="mt-4" v-show="canConnect">
                        <BreezeLabel for="password" value="Password" />
                        <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" autocomplete="current-password" />
                    </div>

                    <div class="mt-4" v-show="isAdmin">
                        <BreezeLabel for="tokenAdmin" :value="__('Token admin')" />
                        <BreezeInput id="tokenAdmin" type="password" class="mt-1 block w-full" v-model="form.tokenAdmin"/>
                    </div>

                    <div class="block mt-4">
                        <label class="flex items-center">
                            <BreezeCheckbox name="remember" v-model:checked="form.remember"/>
                            <span class="ml-2 text-sm text-gray-600">{{__('Remember me')}}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <Link v-if="canResetPassword" :href="route('register')" class="underline text-sm text-white hover:text-gray-300">
                            {{__('you don\'t have an account?')}}
                        </Link>

                        <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            {{__('Log in')}}
                        </BreezeButton>
                    </div>
                </form>
            </div>
        </div>
    </Base>
</template>


<style scoped>
label, span{
    color: white;
}
.login-wrapper{
    height: calc(100% - var(--header-margin));
    width: 100%;
    display: flex;
}
.login{
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
