<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay } from "swiper/modules";
import "swiper/css";

const sponsers = ref([]);
const isLoading = ref(true); // Add loading state

onMounted(async () => {
    try {
        const res = await axios.get("./api/getall/sponser");
        sponsers.value = res.data;

        // If less than 6 items, duplicate to make loop work better
        if (res.data.length < 6) {
            sponsers.value = [...res.data, ...res.data];
        }
    } catch (err) {
        console.error("Error fetching sponsors:", err);
    } finally {
        isLoading.value = false;
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

        <div class="max-w-4xl mx-auto px-4">
            <div v-if="isLoading" class="flex justify-center">
                <!-- Loading placeholder -->
                <div
                    class="w-24 h-24 rounded-full bg-gray-200 animate-pulse"
                ></div>
            </div>

            <Swiper
                v-else
                :modules="[Autoplay]"
                :loop="true"
                :autoplay="{
                    delay: 2500,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                }"
                :slides-per-view="1"
                :centered-slides="true"
                :space-between="30"
                :observer="true"
                :observe-parents="true"
                :breakpoints="{
                    400: { slidesPerView: 1.5, centeredSlides: true },
                    640: { slidesPerView: 2.5, centeredSlides: true },
                    768: { slidesPerView: 3, centeredSlides: true },
                    1024: { slidesPerView: 4, centeredSlides: true },
                }"
                class="w-full"
            >
                <SwiperSlide
                    v-for="(s, index) in sponsers"
                    :key="`${s.id}-${index}`"
                    class="flex justify-center items-center"
                >
                    <div class="flex justify-center w-full px-2">
                        <img
                            :src="s.image"
                            :alt="s.name || 'Partner Logo'"
                            class="w-24 h-24 sm:w-28 sm:h-28 rounded-full object-contain transition-all duration-300 hover:scale-105"
                            loading="lazy"
                        />
                    </div>
                </SwiperSlide>
            </Swiper>
        </div>
    </section>
</template>

<style scoped>
/* Center all slides */
.swiper-slide {
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Smooth transitions */
.swiper-slide img {
    transition: transform 0.3s ease, opacity 0.3s ease;
}

/* Active slide styling */
.swiper-slide-active img {
    transform: scale(1.05);
    opacity: 1;
}

/* Non-active slides */
.swiper-slide:not(.swiper-slide-active) img {
    opacity: 0.8;
}
</style>
