<script setup>
import name from "../../components/name.vue"
import axios from "axios"
import { ref } from "vue";
import { useLocalStorage } from "@vueuse/core";
import { useAlertsStore } from "../../../store/useAlertsStore";

const alertstore = useAlertsStore();
const imageUpload = ref(null);
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

const post = () => { axios.defaults.headers.common['Authorization'] = token.value;
    axios.post('./api/store/banner', formData).then(res => {
        alertstore.showSuccessToast(res.data.message)
    }).catch(error => {
        alertstore.showErrortost(error.response.data.error);
    })
}
</script>
<template>
    <name name="Add New Banner" />
    <div class="bg-gray-100 p-16">
        <div class="border-2  bg-white border-gray-300 shadow-lg max-w-4xl mx-auto rounded shadow-gray-100">
            <div class="w-full  bg-white rounded-lg   md:mt-0 xl:p-0 ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-lg  text-sky-700 leading-tight tracking-wide capitalize">add banner</h1>
                    <form class="mb-6">


                        <div class="mb-6">
                            <label for="file" class="block mb-2 text-sm font-medium text-gray-900 capitalize">Upload Your Banner Photo
                                </label>
                            <input accept=".png,.jpg,.jpeg" type="file" rows="4" ref="imageUpload" @change="selectImage"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                placeholder="Upload your banner photo" />
                        </div>
                        <img v-if="selectedimagedata" :src="selectedimagedata" alt="">

                        <button @click.prevent="post"
                            class="text-white bg-blue-700 hover:bg-blue-800 w-fit mx-auto mt-16 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg capitalize text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 block">Add Banner
                            </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

