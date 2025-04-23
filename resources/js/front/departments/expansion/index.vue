<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";

const services = ref([]);
const serviceCategories = ref([
    {
        title: "Industry and Investment Department ",
        key: "department",
        image: "images/kocha-office.jpg",
    },
    {
        title: "Expansion of Investment",
        key: "expansion",
        image: "images/money-invested.jpg",
    },
    {
        title: "Industry Development",
        key: "development",
        image: "images/IPDC.jpg",
    },
    {
        title: "Mining Licensing",
        key: "miniral",
        image: "images/extraction.jpg",
    },
]);

onMounted(async () => {
    await axios
        .get("/api/service/getall")
        .then((res) => {
            services.value = res.data.services;
        })
        .catch((err) => {});
});
</script>
<template>
    <div class="font-roboto mb-16 w-[90%] mx-auto">
        <!-- Header -->
        <header class="org-header text-center my-12">
            <h3 class="text-3xl md:text-4xl font-extrabold">Our Services</h3>
            <p class="mt-2 text-gray-500 text-sm md:text-base">
                Explore our services across various departments
            </p>
        </header>

        <!-- Services by Category -->
        <div class="space-y-16">
            <div
                v-for="(category, index) in serviceCategories"
                :key="category.key"
                class="flex flex-col md:flex-row gap-8 items-start md:items-stretch"
            >
                <!-- Image -->
                <img
                    v-if="(index + 1) % 2 === 0"
                    :src="category.image"
                    alt="Office"
                    class="w-full md:w-[40%] rounded-xl object-cover shadow"
                />
                <!-- Text Content -->
                <div class="flex-1 bg-white rounded-2xl shadow p-6 md:p-8">
                    <h2 class="text-2xl font-extrabold text-orange-400 mb-4">
                        {{ category.title }}
                    </h2>
                    <ul class="space-y-3">
                        <li
                            v-for="service in services.filter(
                                (s) => s.department === category.key
                            )"
                            :key="`${category.key}-${service.id}`"
                            class="flex items-start gap-3"
                        >
                            <i class="fas fa-check p-2 text-orange-300"></i>

                            <span
                                class="text-gray-700 text-base leading-relaxed"
                            >
                                {{ service.service }}
                            </span>
                        </li>
                    </ul>
                </div>

                <!-- Image -->
                <img
                    v-if="(index + 1) % 2 !== 0"
                    :src="category.image"
                    alt="Office"
                    class="w-full md:w-[40%] rounded-xl object-cover shadow"
                />
            </div>
        </div>
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
