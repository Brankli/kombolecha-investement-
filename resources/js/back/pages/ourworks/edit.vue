<script setup>
import name from "../../components/name.vue"
import axios from "axios"
import { useLocalStorage } from "@vueuse/core";
import { useAlertsStore } from "../../../store/useAlertsStore";

const alertStore = useAlertsStore();
import { onMounted, ref } from "vue";
import { useRoute } from 'vue-router';
const route = useRoute();
const id = ref(route.params.id);
const works = ref('');

onMounted(() => {
    axios.get(`./api/edit/PreviousWork/${id.value}`).then(res => {
        works.value = res.data.previousWork;
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
        formData.append('image', selectedImage);
    }
}

const updatework = () => {
    formData.append('title', works.value.title);
    formData.append('category', works.value.category);
    axios.defaults.headers.common['Authorization'] = token.value;
    axios.post(`./api/update/PreviousWork/${id.value}`, formData).then(res => {
        alertStore.showSuccessToast(res.data.message);
    }).catch(err => {
        alertStore.showErrortost(err.response.data.error);
    })
}
</script>
<template>
    <name name="Update portfolio" />
    <succs v-if="succ" :succ="succ" />
    <errs v-if="err" :err="err" />
    <div class="bg-gray-100 p-16">
        <div class="border-2  bg-white border-gray-300 shadow-lg max-w-4xl mx-auto rounded shadow-gray-100">
            <div class="w-full  bg-white rounded-lg   md:mt-0 xl:p-0 ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-lg  text-sky-700 leading-tight tracking-wide">build your portifolio with privious
                        work
                    </h1>
                    <form class="mb-6">
                        <div class="mb-6">
                            <label for="file" class="block mb-2 text-sm font-medium text-gray-900">Upload image of your
                                work</label>
                            <input accept=".png,.jpg,.jpeg" type="file" rows="4" ref="imageUpload" @change="selectImage"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                placeholder="Your question..." />
                        </div>
                        <img v-if="selectedimagedata" :src="selectedimagedata" class="h-72 object-cover" alt="">

                        <div class="mb-6">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 ">title</label>
                            <input v-model="works.title" type="text" id="phone"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none"
                                placeholder="title of work" required>
                        </div>
                        <div class="mb-6">
                            <label for="sector" class="block mb-2 text-sm font-medium text-gray-900 ">sector</label>
                            <select v-model="works.category" name="time" id="time"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none">
                                <option value="In agro processing sectors" class="hover:bg-slate-500">In agro processing
                                    sectors</option>
                                <option value="In chemical and construction sectors">In chemical and construction
                                    sectors
                                </option>
                                <option value="In the hotel and tourism sector">In the hotel and tourism sector</option>
                                <option value="Construction sectors">Construction sectors</option>
                                <option value="Urban agriculture sector">Urban agriculture sector</option>
                                <option value="Social sectorr">Social sectorr</option>
                            </select>
                        </div>
                        <button @click.prevent="updatework"
                            class="text-white bg-blue-700 hover:bg-blue-800 w-fit mx-auto focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 block">update portfolio</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

