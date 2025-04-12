<template>
    <div class="p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-4">
            <!-- Logo & Department Text -->
            <div
                class="flex flex-col items-center md:items-start text-center md:text-left"
            >
                <img
                    src="/asset/errorimage/logo.png"
                    alt="industrial logo"
                    class="w-28 object-contain mb-3"
                />
                <div class="text-orange-400 text-2xl">
                    <h1 class="font-bold capitalize w-fit">
                        Kombolcha City Industry
                        <span class="lowercase">and</span> Investment department
                    </h1>
                </div>
            </div>

            <!-- Image Slider -->
            <div class="md:col-span-2 w-full">
                <Swiper
                    :modules="[Navigation, Pagination, Autoplay]"
                    :slides-per-view="1"
                    :loop="true"
                    :autoplay="{ delay: 3000, disableOnInteraction: false }"
                    :navigation="true"
                    :pagination="{ clickable: true }"
                    class="rounded-xl shadow-lg overflow-hidden"
                >
                    <!-- Slide 1 -->
                    <SwiperSlide>
                        <div class="relative">
                            <img
                                src="/asset/errorimage/airplain.jpg"
                                class="w-full h-40 md:h-48 object-cover"
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
                                class="w-full h-40 md:h-48 object-cover"
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
                                class="w-full h-40 md:h-48 object-cover"
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
    </div>
</template>

<script setup>
import { Swiper, SwiperSlide } from "swiper/vue";
import { Navigation, Pagination, Autoplay } from "swiper/modules";

import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

const modules = [Navigation, Pagination, Autoplay];
</script>
