<script setup>
import { onMounted, ref, computed } from "vue";
import sidbar from "../components/sidebar.vue"
import resource from "./resource.vue";
import axios from "axios";
const perPage = ref(7);
const currentPage = ref(1);

const resources = ref([]);
onMounted(async () => {
    await axios.get('./api/resource/getall').then(res => {
        resources.value = res.data.resource;
    }).catch(err => console.log(err));
});


const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;
    return resources.value.slice(start, end);
});

const totalPages = computed(() => Math.ceil(resources.value.length / perPage.value));
const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};
</script>

<template>
    <div class="grid lg:grid-cols-6 m-16 ">
        <div class="lg:col-span-4">
            <h1 class="border-b-2 border-gray-200 text-2xl p-5 font-bold text-darkred">Resources</h1>
            <p class="text-md p-4">You Can Download Our Resource as Pdf  </p>
            <div v-for="resource in paginatedData" :key="resource">
                <resource :resource="resource" />
            </div>
            <!-- pagination -->
            <div class="w-full  bg-white mt-16 text-center">
                <div class="flex flex-row gap-4 w-fit mx-auto">
                    <button class="pagnations  hover:bg-gray-300 active:text-darkred" @click="prevPage"
                        :disabled="currentPage === 1"> previous </button>
                    <button class="pagnations  hover:bg-gray-300 active:text-darkred">{{ currentPage }}</button>
                    <button class="pagnations  hover:bg-gray-300 active:text-darkred">...</button>
                    <button class="pagnations  hover:bg-gray-300 active:text-darkred" @click="nextPage"
                        :disabled="currentPage === totalPages">next</button>
                </div>
            </div>
            <!-- pagination -->
        </div>
        <div class="hidden lg:flex lg:col-span-2 md:m-8">
            <sidbar />
        </div>
    </div>
</template>