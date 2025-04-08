<script setup>
import name from "../../components/name.vue"
import axios from "axios"
import { ref, onMounted } from "vue";
import { useLocalStorage } from "@vueuse/core";
import { useRoute } from "vue-router";
import { useAlertsStore } from "../../../store/useAlertsStore";

const alertStore = useAlertsStore();
const route = useRoute();
const id = ref(route.params.id)
const event = ref('');
const imageUpload = ref(null);
const token = useLocalStorage('token', '');
const selectedimagedata = ref('');

onMounted(() => {
    axios.get(`./api/event/edit/${id.value}`).then(res => {
        event.value = res.data.event;
    }).catch(err => console.log(err));
});

const formData = new FormData();

const selectImage = () => {
    const selectedImage = imageUpload.value.files[0];
    selectedimagedata.value = URL.createObjectURL(selectedImage);
    if (selectedImage) {
        formData.append('image', selectedImage);
    }
}

const updateevent = () => {
    formData.append('event', event.value.event);
    formData.append('type', event.value.type);
    formData.append('info', event.value.info)
    axios.defaults.headers.common['Authorization'] = token.value;
    axios.post(`./api/event/update/${id.value}`, formData).then(res => {
        alertStore.showSuccessToast(res.data.message);
    }).catch(err => {
        alertStore.showErrortost(err.response.data.error);
    })
}
</script>
<template>
    <name name="Update Events and Announcments" />
    <div class="bg-gray-100 p-16">
        <div class="border-2  bg-white border-gray-300 shadow-lg max-w-4xl mx-auto rounded shadow-gray-100">
            <div class="w-full  bg-white rounded-lg   md:mt-0 xl:p-0 ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-lg  text-sky-700 leading-tight tracking-wide">Upload Events or Announcements ,Use #
                        For
                        New Paragraph </h1>
                    <form class="mb-6">
                        <div class="mb-6">
                            <label for="file" class="block mb-2 text-sm font-medium text-gray-900">upload image</label>
                            <input accept=".png,.jpg,.jpeg" type="file" rows="4" ref="imageUpload" @change="selectImage"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                placeholder="Your question..." />
                        </div>
                        <img v-if="selectedimagedata" :src="selectedimagedata" class="h-72 object-cover" alt="">

                        <div class="mb-6">
                            <label for="body" class="block mb-2 text-sm font-medium text-gray-900">Content</label>
                            <textarea id="body" v-model="event.event" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                placeholder="Please enter the main body of your news article, providing all relevant details and context. use # for new paragraph"></textarea>
                        </div>
                        <div class="mb-6">
                            <label for="info" class="block mb-2 text-sm font-medium text-gray-900">Information  Source</label>
                            <textarea id="info" v-model="event.info" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                placeholder="# Please include any relevant links to additional information or related articles.."></textarea>
                        </div>
                        <div class="mb-6">
                            <label for="sector" class="block mb-2 text-sm font-medium text-gray-900 ">Category</label>
                            <select v-model="event.type" name="time" id="time"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none">
                                <option selected value="event">Event</option>
                                <option value="announcment">Announcemnt</option>
                            </select>
                        </div>

                        <button @click.prevent="updateevent"
                            class="text-white bg-blue-700 hover:bg-blue-800 w-fit mx-auto focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 block">update
                            Event</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

