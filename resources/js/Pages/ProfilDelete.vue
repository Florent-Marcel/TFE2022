<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import Auth from '@/Layouts/Auth.vue';

const form = useForm({
    password: '',
    confirm: false,
});

const submit = () => {
    console.log(form)
    form.post(route('profil.delete'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Auth>
        <Head :title="__('Delete profil')"/>
        <div class="register-wrapper">
            <div class="register">
                <h3 class="title">{{__("Delete your account with your data")}}</h3>
                <BreezeValidationErrors class="mb-4 errors" />

                <form @submit.prevent="submit">
                    <div class="mt-4">
                        <BreezeLabel for="password" value='Password' />
                        <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required/>
                    </div>
                    <div class="block mt-4">
                        <label class="flex items-center">
                            <BreezeCheckbox name="confirm" v-model:checked="form.confirm"/>
                            <span class="ml-2 text-sm text-gray-600">{{__('I confirm')}}</span>
                        </label>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <!-- <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            {{__("Cancel")}}
                        </BreezeButton> -->
                        <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            {{__("Delete")}}
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
    .title{
        text-align: center;
        color: #F4F3F7;
    }
</style>
