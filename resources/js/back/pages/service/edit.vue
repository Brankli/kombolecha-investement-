<script setup>
import name from "../../components/name.vue"
import axios from "axios"
import { useLocalStorage } from "@vueuse/core";
import { onMounted, ref } from "vue";
import { useRoute } from 'vue-router';
import { useAlertsStore } from "../../../store/useAlertsStore";

const alertStore = useAlertsStore();
const route = useRoute();
const id = ref(route.params.id);
const services = ref('');

onMounted(() => {
    axios.get(`./api/service/edit/${id.value}`).then(res => {
        services.value = res.data.service;
    }).catch(err => console.log(err));
});

const succ = ref('');
const err = ref('');
const token = useLocalStorage('token', '');

const formData = new FormData();
const updateservice = () => {
    formData.append('service', services.value.service);
    formData.append('department', services.value.department);
    axios.defaults.headers.common['Authorization'] = token.value;
    axios.post(`./api/service/update/${id.value}`, formData).then(res => {
        alertStore.showSuccessToast(res.data.message);
    }).catch(err => {
        alertStore.showErrortost(err.response.data.error);
    })
}
</script>
<template>
    <name name="Update Departments service" />
    <div class="bg-gray-100 p-16">
        <div class="border-2  bg-white border-gray-300 shadow-lg max-w-4xl mx-auto rounded shadow-gray-100">
            <div class="w-full  bg-white rounded-lg   md:mt-0 xl:p-0 ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-lg  text-sky-700 leading-tight tracking-wide capitalize">services are edited here</h1>
                    <form class="mb-6">
                        <div class="mb-6">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 capitalize">add service</label>
                            <input v-model="services.service" type="text" id="phone"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none"
                                placeholder="title of work" required>
                        </div>
                        <div class="mb-6">
                                <label for="title" class="block mb-2 text-sm font-medium text-gray-900 capitalize">department</label>
                                    <select v-model="services.department" name="service" id="time"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none">
                                    <option value="miniral">miniral</option>
                                    <option value="development">development</option>
                                    <option value="expansion">expansion</option>
                                    <option value="expansion">department</option>
                                </select>
                            </div>
                        <button @click.prevent="updateservice"
                            class="text-white bg-blue-700 hover:bg-blue-800 w-fit mx-auto focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 capitalize dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 block">update Service</button>
                    </form>
                </div>
            </div>
    </div>
</div></template>

