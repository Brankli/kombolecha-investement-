<script setup>
import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination, Autoplay } from "swiper/modules";

import "swiper/css";
import "swiper/css/pagination";

const modules = [Pagination, Autoplay];
</script>

<template>
    <div class="grid grid-cols-1 md:grid-cols-4 items-center gap-4">
        <div
            class="flex flex-col items-center md:items-start text-center md:text-left"
        >
            <img
                src="/images/logo.png"
                alt="industrial logo"
                class="object-contain h-48"
            />
        </div>
        <div class="md:col-span-3 w-full">
            <Swiper
                :modules="[Pagination, Autoplay]"
                :slides-per-view="1"
                :loop="true"
                :autoplay="{ delay: 3000, disableOnInteraction: false }"
                :pagination="{ clickable: true }"
                class="m-4 rounded shadow-lg overflow-hidden"
            >
                <!-- Slide 1 -->
                <SwiperSlide>
                    <div class="relative">
                        <img
                            src="/asset/errorimage/airplain.jpg"
                            class="w-full h-40 object-cover"
                            alt="Slide 1"
                        />
                        <div
                            class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center"
                        >
                            <h2
                                class="text-white text-xl md:text-2xl font-bold text-center"
                            >
                                Welcome to Kombolcha Industry Zone
                            </h2>
                        </div>
                    </div>
                </SwiperSlide>

                <!-- Slide 2 -->
                <SwiperSlide>
                    <div class="relative">
                        <img
                            src="/asset/errorimage/banner.jpg"
                            class="w-full h-40 object-cover"
                            alt="Slide 2"
                        />
                        <div
                            class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center"
                        >
                            <h2
                                class="text-white text-xl md:text-2xl font-bold text-center"
                            >
                                Invest in a Growing Future
                            </h2>
                        </div>
                    </div>
                </SwiperSlide>

                <!-- Slide 3 -->
                <SwiperSlide>
                    <div class="relative">
                        <img
                            src="/asset/errorimage/industrypark.jpg"
                            class="w-full h-40 object-cover"
                            alt="Slide 3"
                        />
                        <div
                            class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center"
                        >
                            <h2
                                class="text-white text-xl md:text-2xl font-bold text-center"
                            >
                                Empowering Local Business and Innovation
                            </h2>
                        </div>
                    </div>
                </SwiperSlide>
            </Swiper>
        </div>
    </div>
</template>
