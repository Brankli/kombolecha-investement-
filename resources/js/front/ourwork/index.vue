<script setup>
import axios from "axios";
import { ref, computed, onMounted, watch } from "vue";
import ImageZoom from "./ImageZoom.vue";
import navigation from "./components/navigation.vue";

const PreviousWorks = ref([]);
const perPage = ref(10);
const currentPage = ref(1);
const keywords = ref("");
const zoomImage = ref("");

// reset page to 1 on any filter change
watch(keywords, () => {
    currentPage.value = 1;
});

const filteredWorks = computed(() => {
    const kw = keywords.value.toLowerCase().trim();
    return kw === ""
        ? PreviousWorks.value
        : PreviousWorks.value.filter((w) =>
            w.category.toLowerCase().includes(kw)
        );
});

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    return filteredWorks.value.slice(start, start + perPage.value);
});

const totalPages = computed(() =>
    Math.ceil(filteredWorks.value.length / perPage.value)
);

const prevPage = () => {
    if (currentPage.value > 1) currentPage.value--;
};
const nextPage = () => {
    if (currentPage.value < totalPages.value) currentPage.value++;
};

// desktop nav filter
const toggleFilter = (cat) => {
    keywords.value = cat;
    currentPage.value = 1;
};

const zoomOut = (img) => {
    zoomImage.value = zoomImage.value === "" ? img : "";
};

onMounted(async () => {
    try {
        const { data } = await axios.get("./api/getall/PreviousWork");
        PreviousWorks.value = data;
    } catch (err) {
        console.error(err);
    }
});
</script>

<template>
    <ImageZoom v-if="zoomImage" :zoomImage="zoomImage" @some-event="zoomOut" />

    <!-- guard horizontal overflow -->
    <div class="bg-gray-50 min-h-screen text-gray-800 overflow-x-hidden">
        <main class="max-w-7xl mx-auto px-4 py-10"> 
            <header class="org-header text-center">
                <h3 class="text-3xl md:text-4xl font-bold">
                    Our Works
                </h3>
                <p class="mt-2 text-gray-500 text-sm md:text-base">
                    Explore our projects across sectors
                </p>
            </header>

            <!-- Mobile Filter -->
            <div class="md:hidden mb-6 px-4 overflow-x-hidden">
                <select v-model="keywords"
                    class="w-11/12 mx-auto block rounded-xl border border-gray-300 p-3 text-gray-700 shadow-sm focus:ring-2 focus:ring-lime-600 focus:outline-none">
                    <option disabled value="">Select a category…</option>
                    <option>In agro processing sectors</option>
                    <option>In chemical and construction sectors</option>
                    <option>In the hotel and tourism sector</option>
                    <option>Construction sectors</option>
                    <option>Urban agriculture sector</option>
                    <option>Social sectorr</option>
                </select>
            </div>

            <!-- Desktop Filter -->
            <navigation class="hidden md:flex justify-center mb-6" @some-event="toggleFilter" />

            <!-- Grid Cards with hover‑overlay -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <div v-for="work in paginatedData" :key="work.id"
                    class="relative bg-white rounded-2xl shadow-md transform hover:scale-105 hover:shadow-xl transition-all duration-300 overflow-hidden cursor-pointer group"
                    @click.prevent="zoomOut(work.image)">
                    <!-- image -->
                    <img :src="work.image" alt="" class="w-full h-48 object-cover" />

                    <!-- title area -->
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800">
                            {{ work.title }}
                        </h3>
                    </div>

                    <!-- overlay on hover -->
                    <div
                        class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <span class="text-white text-base">
                            {{ work.category }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center items-center gap-4 text-sm">
                <button @click="prevPage" :disabled="currentPage === 1"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 disabled:opacity-40 transition">
                    Previous
                </button>

                <span class="font-semibold text-lime-700">
                    Page {{ currentPage }} of {{ totalPages }}
                </span>

                <button @click="nextPage" :disabled="currentPage === totalPages"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 disabled:opacity-40 transition">
                    Next
                </button>
            </div>
        </main>
    </div>
</template>

<style scoped>
.org-header h3 {
    background: linear-gradient(to right, #84cc16, #10b981);
    -webkit-background-clip: text;
    color: transparent;
    padding: 1rem 0;
}
</style>

