<script setup>
import axios from "axios";
import { ref, onMounted, computed } from "vue";

import heronews from "./component/heronews.vue";
import recentListVue from "./component/recentList.vue";  

const allnews = ref([]);
const perPage = ref(4);
const currentPage = ref(1);
const prehero = ref("1");

const currenthero = ref(1);

function gettingallnews() {
    axios
        .get("./api/news/getall")
        .then((res) => {
            allnews.value = res.data;
        })
        .catch((err) => {
            console.log(err);
        });
}

onMounted(() => {
    gettingallnews();
});

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;
    return allnews.value.slice(start, end);
});

const herodatapagination = computed(() => {
    const start = (currenthero.value - 1) * prehero.value;
    const end = start + prehero.value;
    return allnews.value.slice(start, end);
});
</script>
<template>
     
    <div>
        <h1 class="text-xl font-bold text-yellow-700 my-4">Latest news</h1>
        <div class="grid lg:grid-cols-4 gap-4">
            <div class="lg:col-span-2">
                <div v-for="news in herodatapagination" :key="news.id">
                    <heronews :news="news" />
                </div>
            </div>
            <div class="lg:col-span-2">
                <div v-for="news in paginatedData" :key="news.id">
                    <recentListVue :news="news" />
                </div>
                <router-link to="/news" class="flex items-center w-fit border ml-4 border-yellow-600 rounded-md p-1 px-2 my-8 space-x-2 text-yellow-700 cursor-pointer hover:text-white hover:bg-yellow-700">
                    <i class="fas fa-arrow-right text-xl"></i>
                    <span class="text-md font-bold">More news</span>
                </router-link>
            </div>
        </div>
    </div> 
</template>
