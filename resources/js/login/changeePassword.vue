<script setup>
import axios from 'axios'
import { ref } from 'vue';
import { useRoute } from 'vue-router';
import { useAlertsStore } from "../store/useAlertsStore";

const alertStore = useAlertsStore();
const router = useRoute();
const password_confirmation  = ref('')
const password = ref('')
const error = ref('')
const errors = ref([]);
function changepassword() {
    axios.post(`./api/changepassword/${router.params.id}`, {
        password_confirmation : password_confirmation .value,
        password: password.value
    }).then(res => {
        alertStore.showSuccessToast(res.data.message);
        setTimeout(() => {
            password_confirmation.value = '',
            password.value = ''
        }, 2000);
    }).catch(err => {
        if (err.response.status == 422) {
            errors.value = err.response.data.error
        } else{
            alertStore.showErrortost(err.response.data.error)
        }
    });

}


</script>
<template>
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full bg-white rounded-lg shadow-2xl  md:mt-0 sm:max-w-md xl:p-0 ">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-md leading-tight text-sky-500 tracking-tight">
                    change new password
                </h1>
                <p class="text-rose-600" v-if="error">{{ error }}</p>
                <form class="space-y-4 md:space-y-6" action="#">
                    <div>
                        <p class="text-rose-500" v-if="errors.password">{{ errors.password[0] }}</p>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 capitalize">new
                            Password</label>
                        <input v-model="password" type="password" name="password" id="password"
                            class="bg-gray-50 border border-sky-300 text-gray-900 sm:text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5 outline-none"
                            required>
                    </div>
                    <div>
                        <p class="text-rose-500" v-if="errors.password">{{ errors.password[1] }}</p>
                        <label for="password_confirmation password"
                            class="block mb-2 text-sm font-medium text-gray-900 capitalize">confirm new
                            password</label>
                        <input v-model="password_confirmation " type="password" name="password_confirmation password"
                            id="password_confirmation password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5 outline-none "
                            required>
                    </div>
                    <button @click.prevent="changepassword"
                        class="w-full text-white bg-sky-700 hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Save</button>
                </form>
            </div>
        </div>
    </div>
</template>