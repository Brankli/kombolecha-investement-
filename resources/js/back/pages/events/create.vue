<script setup>
import name from "../../components/name.vue"
import axios from "axios"
import { ref } from "vue";
import { useLocalStorage } from "@vueuse/core";
import { useAlertsStore } from "../../../store/useAlertsStore";

const alertStore = useAlertsStore();
const event = ref('');
const type = ref('');
const imageUpload = ref(null);
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

const postevent = () => {
    formData.append('event', event.value);
    formData.append('type', type.value);
    formData.append('info', info.value);
    axios.defaults.headers.common['Authorization'] = token.value;
    axios.post('./api/event/store', formData).then(res => {
        alertStore.showSuccessToast(res.data.message);
        setTimeout(() => {
            event.value = '';
            type.value = '';
            info.value = '';            
        }, 2000);
    }).catch(res => {
        alertStore.showErrortost(err.response.data.error);
    })
}
</script>
<template>
    <name name="New Events and Announcement" />
    <div class="bg-gray-100 p-16">
        <div class="border-2  bg-white border-gray-300 shadow-lg max-w-4xl mx-auto rounded shadow-gray-100">
            <div class="w-full  bg-white rounded-lg   md:mt-0 xl:p-0 ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-lg  text-sky-700 leading-tight tracking-wide capitalize">please read Describtion and
                        follow
                        instructions inside text filds</h1>
                    <form class="mb-6">
                        <div class="mb-6">
                            <label for="file" class="block mb-2 text-sm font-medium text-gray-900">Upload Event
                                Image</label>
                            <input accept=".png,.jpg,.jpeg" type="file" rows="4" ref="imageUpload" @change="selectImage"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                placeholder="Your question..." />
                        </div>
                        <img v-if="selectedimagedata" :src="selectedimagedata" class="h-72 object-cover" alt="">

                        <div class="mb-6">
                            <label for="body" class="block mb-2 text-sm font-medium text-gray-900"> Content</label>
                            <textarea id="body" v-model="event" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                placeholder="Please enter the main body, providing all relevant details ... not forgrt to use # for new paragraphs in new line."></textarea>
                        </div>
                        <div class="mb-6">
                            <label for="info" class="block mb-2 text-sm font-medium text-gray-900">Information
                                Source</label>
                            <textarea id="info" v-model="info" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                placeholder="# Please include any relevant links to additional information or related articles that help your audience browse more"></textarea>
                        </div>
                        <div class="mb-6">
                            <label for="sector" class="block mb-2 text-sm font-medium text-gray-900 ">Category</label>
                            <select v-model="type" name="time" id="time"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none">
                                <option selected value="event">Event</option>
                                <option value="announcment">Announcemnt</option>
                            </select>
                        </div>
                        <button @click.prevent="postevent"
                            class="text-white bg-blue-700 hover:bg-blue-800 w-fit mx-auto focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 block">add
                            Events </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

