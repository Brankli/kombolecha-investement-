<script setup>
import { onMounted, ref, computed } from "vue";
import Sidbar from "../components/sidebar.vue";
import ResourceCard from "./resource.vue";
import axios from "axios";

const perPage = ref(7);
const currentPage = ref(1);
const resources = ref([]);

onMounted(async () => {
    try {
        const res = await axios.get("/api/resource/getall");
        resources.value = res.data.resource;
    } catch (err) {
        console.error(err);
    }
});

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    return resources.value.slice(start, start + perPage.value);
});

const totalPages = computed(() =>
    Math.ceil(resources.value.length / perPage.value)
);

function prevPage() {
    if (currentPage.value > 1) currentPage.value--;
}

function nextPage() {
    if (currentPage.value < totalPages.value) currentPage.value++;
}
</script>

<template>
    <div class="grid lg:grid-cols-6 gap-6 p-3">
        <!-- Main content -->
        <section class="lg:col-span-4">
            <h1
                class="border-b-2 border-gray-200 text-2xl font-bold text-darkred mb-2"
            >
                Resources
            </h1>
            <p class="text-md mb-6">You Can Download Our Resource as PDF</p>

            <div class="space-y-4">
                <ResourceCard
                    v-for="item in paginatedData"
                    :key="item.id"
                    :resource="item"
                />
            </div>

            <div class="bg-white mt-8 py-4">
                <div class="flex justify-center items-center gap-4">
                    <button
                        class="px-4 py-2 bg-gray-100 rounded hover:bg-gray-200 disabled:opacity-50"
                        @click="prevPage"
                        :disabled="currentPage === 1"
                    >
                        Previous
                    </button>
                    <span class="px-4 py-2 bg-gray-100 rounded">
                        {{ currentPage }} / {{ totalPages }}
                    </span>
                    <button
                        class="px-4 py-2 bg-gray-100 rounded hover:bg-gray-200 disabled:opacity-50"
                        @click="nextPage"
                        :disabled="currentPage === totalPages"
                    >
                        Next
                    </button>
                </div>
            </div>
        </section>

        <!-- Sidebar -->
        <aside class="hidden lg:block lg:col-span-2">
            <Sidbar />
        </aside>
    </div>
</template>
