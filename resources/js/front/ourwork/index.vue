<script setup>
import Card from "./components/card.vue"
import immagezoom from "./immagezoom.vue";
import axios from "axios";
import { onMounted, ref, computed } from "vue";
import { format, parseISO } from 'date-fns';
const PreviousWorks = ref([]);
const perPage = ref(10);
const currentPage = ref(1);
const keywords = ref('');
const zoomimage = ref('');
import navigation from "./components/navigation.vue"
onMounted(async () => {
    try {
        await axios.get('./api/getall/PreviousWork').then(res => {
            PreviousWorks.value = res.data;
        }).catch(err => console.log(err));
    } catch (err) {
        console.error(err);
    }
});

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

const formatDate = (isoDateString) => {
    const date = parseISO(isoDateString);
    return format(date, 'yyyy-MM-dd');
};
const togglefilter = (event)=>{
    keywords.value = event;
}

const zoomout = (zoom)=>{
    zoomimage.value = zoomimage.value === '' ? zoom : '';
}
</script>
<template>
    <immagezoom v-if="zoomimage" :zoomimage="zoomimage" @some-event="zoomout" />
    <div class=" text-colorbackground mt-4  z-0">
        <div class="">
            <main class="px-4 py-6 bg-white ">
                <header>
                    <div>
                        <div class=" border-b  border-gray-200 z-0 ">
                            <h3 class="font-semibold text-2xl pb-2  ">
                                {{ $t('lang.WorkSector') }}
                            </h3>
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
                        <navigation @some-event="togglefilter" />
                        <div class="mt-8 grid lg:grid-cols-4 gap-6">

                            <div v-for="work in paginatedData" :key="work.id">
                                <Card :work="work" @click.prevent="zoomout(work.image)" />
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