<script setup>
import { onMounted, ref, computed } from "vue";
import axios from "axios";

const perPage = ref(3);
const currentPage = ref(1);
const testimonial = ref([]);

onMounted(async () => {
  try {
    const res = await axios.get(`./api/getall/testimonial`);
    testimonial.value = res.data;
  } catch (err) {
    console.log(err);
  }
});

const paginatedData = computed(() => {
  const start = (currentPage.value - 1) * perPage.value;
  const end = start + perPage.value;
  return testimonial.value.slice(start, end);
});

const totalPages = computed(() =>
  Math.ceil(testimonial.value.length / perPage.value)
);

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};
</script>

<template>
  <div class="py-10 sm:py-12 bg-gray-50 lg:py-14">
    <div class="px-4 mx-auto sm:px-6 lg:px-8">
      <div class="flex flex-col items-center">
        <!-- Heading -->
        <div class="text-center mb-6">
          <h2 class="text-2xl sm:text-3xl xl:text-4xl font-bold text-darkred font-pj">
            {{ $t('lang.Testimonial') }}
          </h2>
        </div>

      <!-- Navigation Arrows and Dots -->
        <div class="flex gap-4 justify-center items-center mb-6">
          <button
            @click="prevPage"
            :disabled="currentPage === 1"
            class="rounded-full border border-darkblue bg-white text-darkblue hover:bg-darkblue hover:text-white transition p-2 shadow-md disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <i class="material-icons text-2xl">keyboard_double_arrow_left</i>
          </button>

          <div class="flex items-center gap-2">
            <span
              v-for="n in totalPages"
              :key="n"
              class="w-2.5 h-2.5 rounded-full transition-all duration-200"
              :class="{
                'bg-darkblue': currentPage === n,
                'bg-gray-300': currentPage !== n
              }"
            ></span>
          </div>

          <button
            @click="nextPage"
            :disabled="currentPage === totalPages"
            class="rounded-full border border-darkblue bg-white text-darkblue hover:bg-darkblue hover:text-white transition p-2 shadow-md disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <i class="material-icons text-2xl">double_arrow</i>
          </button>
        </div>

        <!-- Testimonials Cards -->
        <div
          class="grid grid-cols-1 gap-6 mx-auto md:grid-cols-2 lg:grid-cols-3 lg:gap-10 max-w-5xl"
        >
          <div
            v-for="test in paginatedData"
            :key="test.id"
            class="flex flex-col min-h-[320px] overflow-hidden shadow-md rounded-2xl bg-white transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1 animate-fadeIn"
          >
            <div class="flex flex-col flex-1 p-6 lg:py-6 lg:px-5">
              <!-- Image + Name -->
              <div class="flex items-center gap-4 mb-4">
                <img
                  :src="test.image"
                  alt=""
                  class="w-20 h-20 object-cover rounded-full border-[2px] border-yellow-500 shadow-lg transform transition-transform duration-300 hover:scale-105 ml-2"
                />
                <p class="text-lg font-bold text-blue-700 capitalize font-pj">
                  {{ test.Name }}
                </p>
              </div>

              <!-- Stars -->
              <div class="flex items-center justify-start mb-3 pl-2">
                <div v-for="star in [1, 2, 3, 4, 5]" :key="star">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 96 960 960"
                    class="w-5 h-5 text-yellow-500"
                  >
                    <path
                      fill="currentColor"
                      d="m233 976 65-281L80 506l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Z"
                    />
                  </svg>
                </div>
              </div>

              <!-- Description -->
              <blockquote class="flex-1 mt-2">
                <p
                  class="text-md leading-relaxed text-gray-900 font-normal text-left indent-4 pr-2"
                >
                  “{{ test.discribution }}”
                </p>
              </blockquote>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@keyframes fadeIn {
  0% {
    opacity: 0;
    transform: translateY(20px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fadeIn {
  animation: fadeIn 0.6s ease-out;
}
</style>
