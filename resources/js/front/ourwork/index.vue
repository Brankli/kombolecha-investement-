<script setup>
import axios from "axios";
import { onMounted, ref, computed } from "vue";

import ImageZoom from "./ImageZoom.vue";
import Card from "./components/card.vue";
import navigation from "./components/navigation.vue";

const PreviousWorks = ref([]);
const perPage = ref(10);
const currentPage = ref(1);
const keywords = ref('');
const zoomImage = ref('');

const filteredWorks = computed(() => {
    const keyword = keywords.value.toLowerCase();

    if (keyword == '') {
        return PreviousWorks.value;
    } else {
        return PreviousWorks.value.filter(item => item.category.toLowerCase() === keyword);
    }
});

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;
    return filteredWorks.value.slice(start, end);
});

const totalPages = computed(() => Math.ceil(filteredWorks.value.length / perPage.value));
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
 
const toggleFilter = (event) => {
    keywords.value = event;
}

const zoomOut = (zoom) => {
    zoomImage.value = zoomImage.value === '' ? zoom : '';
}

onMounted(async () => {
    try {
        await axios.get('./api/getall/PreviousWork').then(res => {
            PreviousWorks.value = res.data;
        }).catch(err => console.log(err));
    } catch (err) {
        console.error(err);
    }
});

</script>
<template>
    <ImageZoom v-if="zoomImage" 
        :zoomImage="zoomImage" 
        @some-event="zoomOut" />

    <div class=" text-colorbackground mt-4  z-0">
        <div class="">
            <main class="px-4 py-6 bg-white ">
                <header>
                    <div>
                        <div class=" z-0 ">
                            <div class="text-center py-8">
                                <h3 class="font-bold text-4xl"> Our Works </h3>
                            </div>

                            <div class="sm:hidden block">
                                <select v-model="keywords" name="time" id="time"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  w-full p-2 outline-none">
                                    <option value="In agro processing sectors" class="hover:bg-slate-500">In agro
                                        processing
                                        sectors</option>
                                    <option value="In chemical and construction sectors">In chemical and construction
                                        sectors</option>
                                    <option value="In the hotel and tourism sector">In the hotel and tourism sector
                                    </option>
                                    <option value="Construction sectors">Construction sectors</option>
                                    <option value="Urban agriculture sector">Urban Agriculture Sector</option>
                                    <option value="Social sectorr">Social Sector</option>
                                </select>
                            </div>
                        </div>
                        
                        <navigation 
                            class="hidden md:flex" 
                            @some-event="toggleFilter" />

                        <div class="my-12 flex flex-wrap lg:w-[90%] items-center justify-center gap-4 mx-auto">
                            <div v-for="work in paginatedData" 
                                :key="work.id" 
                                class="flex-grow max-w-[350px] group relative overflow-hidden shadow-lg bg-white hover:shadow-2xl transition-shadow duration-300 cursor-pointer portfolio-item">
                                <Card 
                                    :work="work"
                                    @click.prevent="zoomOut(work.image)" />
                            </div>
                        </div>
                    </div>

                </header>
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
            </main>
        </div>
    </div>
</template>