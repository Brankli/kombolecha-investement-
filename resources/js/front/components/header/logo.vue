<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination, Autoplay, Navigation } from "swiper/modules";
import { useLocalStorage } from "@vueuse/core";

import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";

const sliders = ref([]);
const token = useLocalStorage("token", "");
const modules = [Pagination, Autoplay, Navigation];

onMounted(async () => {
    try {
        axios.defaults.headers.common["Authorization"] = token.value;
        const { data } = await axios.get("/api/getall/sliders");
        sliders.value = data.data;
    } catch (error) {
        console.error("Failed to fetch sliders:", error);
    }
});
</script>

<template>
    <div class="grid grid-cols-1 md:grid-cols-4 items-center gap-4">
        <!-- Logo Column -->
        <div
            class="flex flex-col items-center md:items-start text-center md:text-left"
        >
            <img
                src="/images/logo.png"
                alt="industrial logo"
                class="object-contain h-48"
            />
        </div>

        <!-- Slider Column -->
        <div class="md:col-span-3 w-full hidden md:block">
            <!-- Banner-style Title -->
            <div class="mb-4 text-center md:text-left">
                <h1
                    class="text-1xl md:text-2xl font-extrabold text-orange-500 border-l-4 border-orange-400 pl-4 uppercase tracking-widest"
                >
                    Featured News
                </h1>
                <div
                    class="w-16 h-1 bg-orange-500 mt-2 mx-auto md:mx-0 rounded"
                ></div>
            </div>

            <!-- Swiper Component -->
            <Swiper
                v-if="sliders.length"
                :modules="modules"
                :slides-per-view="1"
                :loop="true"
                :autoplay="{ delay: 3000, disableOnInteraction: false }"
                :pagination="{ clickable: true }"
                navigation
                class="m-4 rounded shadow-lg overflow-hidden"
            >
                <SwiperSlide v-for="(slide, i) in sliders" :key="i">
                    <div class="relative">
                        <img
                            :src="slide.image"
                            class="w-full h-40 object-cover"
                            :alt="slide.title"
                        />
                        <div
                            class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center p-4"
                        >
                            <div
                                class="bg-white/20 backdrop-blur-md px-6 py-4 rounded-xl shadow-lg border border-white/30 text-center max-w-2xl"
                            >
                                <h2
                                    class="text-orange-500 text-xl md:text-2xl font-bold uppercase tracking-wide drop-shadow mb-2"
                                >
                                    {{ slide.title }}
                                </h2>
                                <p
                                    class="text-white text-sm md:text-base drop-shadow"
                                >
                                    {{ slide.description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </SwiperSlide>
            </Swiper>

            <!-- Loading State -->
            <div v-else class="p-8 text-center text-gray-500">
                Loading slides…
            </div>
        </div>
    </div>
</template>
