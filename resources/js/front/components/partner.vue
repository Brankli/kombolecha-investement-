<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Navigation } from "swiper/modules"; // ✅ Correct way to import modules
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/autoplay";

const sponsers = ref([]);

onMounted(async () => {
    try {
        const res = await axios.get("./api/getall/sponser");
        sponsers.value = res.data;
    } catch (err) {
        console.log(err);
    }
});
</script>
<template>
    <div class="relative m-16">
        <div class="text-center">
            <h1
                class="mt-4 text-2xl font-bold text-darkred sm:text-3xl xl:text-4xl font-pj"
            >
                {{ $t("lang.Partners") }}
            </h1>
        </div>

        <!-- Custom Arrows -->
        <!-- Custom Arrows -->
        <div
            class="absolute -left-6 top-1/2 z-10 mt-12 transform -translate-y-1/2 cursor-pointer bg-blue-500 shadow-lg rounded-full p-2 hover:bg-blue-600 transition"
            id="custom-prev"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-white"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M15 19l-7-7 7-7"
                />
            </svg>
        </div>

        <div
            class="absolute -right-6 top-1/2 z-10 mt-12 transform -translate-y-1/2 cursor-pointer bg-blue-500 shadow-lg rounded-full p-2 hover:bg-blue-600 transition"
            id="custom-next"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-white"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M9 5l7 7-7 7"
                />
            </svg>
        </div>

        <!-- Swiper Slider -->
        <Swiper
            :modules="[Autoplay, Navigation]"
            :slides-per-view="6"
            :space-between="10"
            :loop="true"
            :autoplay="{ delay: 2000, disableOnInteraction: false }"
            :navigation="{ prevEl: '#custom-prev', nextEl: '#custom-next' }"
            class="mt-16"
        >
            <SwiperSlide v-for="sponser in sponsers" :key="sponser.id">
                <div class="flex justify-center">
                    <img
                        :src="sponser.image"
                        alt="Sponser Logo"
                        class="h-16 object-contain"
                    />
                </div>
            </SwiperSlide>
        </Swiper>
    </div>
</template>
