<script setup>
import name from "../../components/name.vue"
import axios from "axios"
import { useLocalStorage } from "@vueuse/core";
import { onMounted, ref } from "vue";
import { useRoute } from 'vue-router';
import { useAlertsStore } from "../../../store/useAlertsStore";

const alertstore = useAlertsStore();
const route = useRoute();
const id = ref(route.params.id);
const news = ref('');

onMounted(() => {
    axios.get(`./api/news/edit/${id.value}`).then(res => {
        news.value = res.data.news;
        console.log(news.value);
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

const update = () => {
    formData.append('title', news.value.title);
    formData.append('content', news.value.content);
    formData.append('info', news.value.info);
    axios.defaults.headers.common['Authorization'] = token.value;
    axios.post(`./api/news/update/${id.value}`, formData).then(res => {
        alertstore.showSuccessToast(res.data.message);
    }).catch(err => {
        alertStore.showErrortost(err.response.data.error);
    })
}
</script>
<template>
    <name name="Update News" />
    <succs v-if="succ" :succ="succ" />
    <errs v-if="err" :err="err" />
    <div class="bg-gray-100 p-16">
        <div class="border-2  bg-white border-gray-300 shadow-lg max-w-4xl mx-auto rounded shadow-gray-100">
            <div class="w-full  bg-white rounded-lg   md:mt-0 xl:p-0 ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-lg  text-sky-700 leading-tight tracking-wide capitalize">use '#' for new paragraph
                        and
                        complet
                        your news </h1>
                    <form class="mb-6">
                        <div class="mb-6">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 capitalize">News
                                Article.</label>
                            <textarea id="title" v-model="news.title" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                placeholder="Please enter a catchy and informative headline for your news article"></textarea>
                        </div>
                        <div class="mb-6">
                            <label for="body" class="block mb-2 text-sm font-medium text-gray-900 capitalize">News
                                content</label>
                            <textarea id="body" v-model="news.content" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                placeholder="Please enter the main body of your news article, providing all relevant details and context."></textarea>
                        </div>
                        <div class="mb-6">
                            <label for="file" class="block mb-2 text-sm font-medium text-gray-900 capitalize">Upload image for your news</label>
                            <input accept=".png,.jpg,.jpeg" type="file" rows="4" ref="imageUpload" @change="selectImage"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                placeholder="Your question..." />
                        </div>
                        <img v-if="selectedimagedata" class="h-72 object-cover" :src="selectedimagedata" alt="">
                        <div class="mb-6">
                            <label for="info"
                                class="block mb-2 text-sm font-medium text-gray-900 capitalize">information source</label>
                            <textarea id="info" v-model="news.info" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                placeholder="# Please include any relevant links to additional information or related articles.."></textarea>
                        </div>
                        <button @click.prevent="update"
                            class="text-white bg-blue-700 capitalize hover:bg-blue-800 w-fit mx-auto focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 block">update
                            news</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

