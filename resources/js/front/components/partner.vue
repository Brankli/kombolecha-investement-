<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

// Swiper Vue.js components + Autoplay module
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay } from "swiper/modules";

// Only the base Swiper CSS is needed
import "swiper/css";

const sponsers = ref([]);
let swiperInstance = null;

// Grab the Swiper instance and force‑start autoplay
const onSwiper = (swiper) => {
    swiperInstance = swiper;
    swiper.autoplay.start();
};

onMounted(async () => {
    try {
        const res = await axios.get("./api/getall/sponser");
        sponsers.value = res.data;
    } catch (err) {
        console.error("Error fetching sponsors:", err);
    }
});
</script>

<template>
    <section class="py-16 bg-white">
        <div class="text-center mb-10">
            <h2
                class="text-2xl sm:text-3xl xl:text-4xl font-bold text-orange-400"
            >
                {{ $t("lang.Partners") }}
            </h2>
        </div>

        <div class="max-w-4xl mx-auto">
            <Swiper
                :modules="[Autoplay]"
                :loop="true"
                :autoplay="{ delay: 2500, disableOnInteraction: false }"
                :slides-per-view="1"
                :centeredSlides="true"
                :spaceBetween="20"
                :observer="true"
                :observeParents="true"
                :breakpoints="{
                    640: { slidesPerView: 2, centeredSlides: true },
                    1024: { slidesPerView: 3, centeredSlides: true },
                }"
                @swiper="onSwiper"
                class="w-full"
            >
                <SwiperSlide
                    v-for="s in sponsers"
                    :key="s.id"
                    class="flex justify-center items-center"
                >
                    <img
                        :src="s.image"
                        :alt="s.name || 'Partner Logo'"
                        class="w-24 h-24 sm:w-28 sm:h-28 rounded-full object-contain transition-transform duration-300"
                    />
                </SwiperSlide>
            </Swiper>
        </div>
    </section>
</template>

<style scoped>
/* Ensure no bullets ever appear */
.swiper-pagination {
    display: none !important;
}
/* Force each slide to center its content */
.swiper-slide {
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
}
</style>
