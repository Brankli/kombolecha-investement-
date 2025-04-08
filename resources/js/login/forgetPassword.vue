<script setup>
import axios from "axios"
import { ref } from 'vue';
import { useAlertsStore } from "../store/useAlertsStore";

const alertStore = useAlertsStore();
const email = ref('');
const errors = ref([]);
const error = ref();
const forgotpassword = ()=>{
    axios.post('./api/resetpassword',{email:email.value}).then(res => {
        alertStore.showSuccessToast(res.data.message);
    }).catch(err => {
        if (err.response.status == 422) {
            errors.value = err.response.data.error
        } else {
            error.value = err.response.data.error;
        }
})
}
</script>

<template>
    <div class="flex items-center justify-center">
        <div class="w-full bg-white rounded-lg shadow-2xl  md:mt-0 sm:max-w-md xl:p-0 ">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-md leading-tight text-sky-500 capitalize tracking-tight">
                    {{ $t('lang.rpEmail') }}
                </h1>
                <p class="text-green-600" v-if="succ">{{ succ }}</p>
                <p class="text-rose-600" v-if="error">{{ error }}</p>
                <form class="space-y-4 md:space-y-6" action="#">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">{{$t('lang.E-mail') }}</label>
                        <h1 v-if="errors.email" class="font-normal p-md text-md text-red-500 capitalize">{{
                            errors.email[0] }}</h1>
                        <input type="email" v-model="email" name="email" id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5 outline-none "
                            placeholder="name@gmail.com" required>
                    </div>
                    <button @click.prevent="forgotpassword"
                        class="w-full text-white capitalize bg-sky-700 hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">{{
    $t('lang.getemail') }}</button>
                </form>
            </div>
        </div>
    </div>
</template>