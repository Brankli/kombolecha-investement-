<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import axios from 'axios';

const banners = ref([]);
const activeSlide = ref(0);
let interval = ref(null);

const fetchBanners = async () => {
  try {
    const response = await axios.get('./api/getall/banner');
    banners.value = response.data;
  } catch (error) {
    console.error("Failed to load banners:", error);
  }
};

const startAutoSlide = () => {
  stopAutoSlide();  // Ensures no duplicate intervals
  interval.value = setInterval(() => {
    nextSlide();
  }, 3000);  // Automatically change slides every 3 seconds
};

const stopAutoSlide = () => {
  if (interval.value) {
    clearInterval(interval.value);
    interval.value = null;
  }
};

const nextSlide = () => {
  activeSlide.value = (activeSlide.value + 1) % banners.value.length;
};

const prevSlide = () => {
  activeSlide.value = (activeSlide.value - 1 + banners.value.length) % banners.value.length;
};

const isSlideActive = (index) => {
  return index === activeSlide.value;
};

onMounted(() => {
  fetchBanners();
  startAutoSlide();
});

onUnmounted(() => {
  stopAutoSlide();
});
</script>




<template>
  <div class="">
    <div v-if="banners" id="carouselExampleCaptions" class="relative overflow-hidden" @mouseenter="stopAutoSlide"
      @mouseleave="startAutoSlide">
      <div class="w-full flex"
        style="transform: translateX(calc(-100% * activeSlide)); transition: transform 0.5s ease-in-out"
        data-twe-carousel-init data-twe-ride="carousel">
        <div v-for="(banner, index) in banners" :key="index"
          class="w-full flex-none transition duration-500 ease-in-out transform relative"
          :class="{ 'hidden': !isSlideActive(index), 'opacity-0': !isSlideActive(index), 'opacity-100': isSlideActive(index) }"
          style="transition: opacity 0.5s ease-in-out;">
          <!-- Aspect ratio container -->
          <div class="relative w-full" style="padding-top: 56.25%;">
            <img :src="banner.image" class="absolute top-0 left-0 w-full h-full object-cover" :alt="banner.alt" />
          </div>
        </div>
      </div>

      <div class="absolute bottom-0 left-0 right-0 z-10 mx-[15%] mb-4 flex list-none justify-center p-0"
        data-twe-carousel-indicators>
        <button v-for="(banner, index) in banners" :key="index" :class="{ 'active': isSlideActive(index) }"
          @click="activeSlide = index"
          class="mx-[3px] box-content h-[3px] w-[30px] flex-initial cursor-pointer border-0 border-y-[10px] border-solid border-transparent bg-white bg-clip-padding p-0 -indent-[999px] opacity-50 transition-opacity duration-[600ms] ease-[cubic-bezier(0.25,0.1,0.25,1.0)] motion-reduce:transition-none"
          aria-label="Slide {{ index + 1 }}">
        </button>
      </div>

      <button @click="prevSlide"
        class="absolute top-0 bottom-0 left-0 z-10 flex cursor-pointer align-middle my-auto h-fit shadow bg-gray-100 p-2 active:text-darkred  rounded duration-300">
        <span> <i class="material-icons text-darkblue font-xl">keyboard_double_arrow_left</i></span>
      </button>
      <button @click="nextSlide"
        class="absolute top-0 bottom-0 right-0 z-10 flex  cursor-pointer align-middle  p-2 bg-gray-100 active:text-darkred  h-fit my-auto  rounded duration-300">
        <span> <i class="material-icons text-darkblue font-xl">double_arrow</i></span>
      </button>
    </div>
  </div>

</template>

<style>
#carouselExampleCaptions {
  width: 77%;
  margin: 0 auto;

  height: auto;

}

[data-twe-carousel-init]>div {
  width: 80%;
  height: auto;
  margin: auto;
}

.relative.w-full {
  height: 400px;
}

img {
  height: 100%;
  /* Adjust based on your needs */
  object-fit: cover;
  /* Keeps the image aspect while fitting to the new size */
}
</style>