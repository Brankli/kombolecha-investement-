<script setup>
import name from "../../../components/name.vue";
import axios from "axios"
import { useLocalStorage } from "@vueuse/core";
import { onMounted, ref } from "vue";
import { useRoute } from 'vue-router';
import succs from "../../conformation/succ.vue";
import errs from "../../conformation/err.vue";
const route = useRoute();
const id = ref(route.params.id);
const department = ref('');

onMounted(() => {
    axios.get(`./api/edit/department/${id.value}`).then(res => {
        department.value = res.data.DepartmentContent;
    }).catch(err => console.log(err));
});

const imageUpload = ref(null);
const succ = ref('');
const err = ref('');
const token = useLocalStorage('token', '');
const selectedimagedata = ref('');

const formData = new FormData();

const selectImage = () => {
    const selectedImage = imageUpload.value.files[0];
    selectedimagedata.value = URL.createObjectURL(selectedImage);
    if (selectedImage) {
        formData.append('profile', selectedImage);
    }
}

const updatedepatments = () => {
    formData.append('name', department.value.name);
    formData.append('email', department.value.email);
    formData.append('phone_no', department.value.phone_no);
    formData.append('vission', department.value.vission);
    formData.append('mission', department.value.mission);
    formData.append('goal', department.value.goal);
    axios.defaults.headers.common['Authorization'] = token.value;
    axios.post(`./api/update/department/${id.value}`, formData).then(res => {
        succ.value = res.data.message;
        window.location.href = "/admin#/content";
    }).catch(res => {
        err.value = res.data;
    })
}
</script>
<template>
    <name name="Edit Department Content" />
    <succs v-if="succ" :succ="succ" />
    <errs v-if="err" :err="err" />
    <div class="bg-gray-100 p-16">
        <div class="border-2  bg-white border-gray-300 shadow-lg max-w-4xl mx-auto rounded shadow-gray-100">
            <div class="w-full  bg-white rounded-lg   md:mt-0 xl:p-0 ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-lg  text-sky-700 leading-tight tracking-wide capitalize">manage departments profile</h1>
                    <form class="mb-6">
                        <div class="mb-6">
                            <label for="file" class="block mb-2 text-sm font-medium text-gray-900 capitalize">Upload your photo</label>
                            <input accept=".png,.jpg,.jpeg" type="file" rows="4" ref="imageUpload" @change="selectImage"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                placeholder="Your question..." />
                        </div>
                        <img v-if="selectedimagedata" :src="selectedimagedata" class="h-72 object-cover" alt="">
                        <div class="mb-6">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 capitalize"> director name</label>
                            <input v-model="department.name" type="text" id="phone"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none"
                                placeholder="title of work" required>
                        </div>
                        <div class="mb-6">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 capitalize">email</label>
                            <input v-model="department.email" type="text" id="phone"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none"
                                placeholder="email example@gmail.com" required>
                        </div>
                        <div class="mb-6">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 capitalize"> phone number</label>
                            <input v-model="department.phone_no" type="text" id="phone"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none"
                                placeholder="title of work" required>
                        </div>
                        <div v-if="department.position === 'deparment head' || department.position === 'miniral director'" >
                        <div class="mb-6">
                            <label for="vission" class="block mb-2 text-sm font-medium text-gray-900 capitalize">your vission</label>
                            <input v-model="department.vission" type="text" id="vission"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none"
                                placeholder="vision" required>
                        </div>
                        <div class="mb-6">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 capitalize">your mission</label>
                            <input v-model="department.mission" type="text" id="phone"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none"
                                placeholder="title of work" required>
                        </div>
                        <div class="mb-6">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 capitalize">your goal</label>
                            <input v-model="department.goal" type="text" id="phone"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none"
                                placeholder="title of work" required>
                        </div>
                        </div>
                        <button @click.prevent="updatedepatments"
                            class="text-white bg-blue-700 hover:bg-blue-800 w-full focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 block">update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

