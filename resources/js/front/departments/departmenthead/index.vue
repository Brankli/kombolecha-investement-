<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";

import ourTeam from "./ourTeam.vue";

const aboutus = ref(null);

onMounted(async () => {
  await axios
    .get("/api/getall/department")
    .then((res) => {
      aboutus.value = res.data.data;
    })
    .catch((err) => console.log(err));
});
</script>

<template>
  <div class="">
    <header class="org-header text-center my-12">
      <h3 class="text-3xl md:text-4xl font-bold">About us</h3>
      <p class="mt-2 text-gray-500 text-sm md:text-base">
        About Kombolcha city industry and investment deparment.
      </p>
    </header>

    <div class="w-[90%] lg:w-[80%] mx-auto my-8 mb-16">
      <div>
        <div class="w-full flex flex-col md:flex-row gap-8 mx-auto">
          <div class="flex border border-gray-300 rounded-lg p-4 flex-col">
            <h1 class="font-bold text-2xl py-6 text-blue-900">Our Vision</h1>
            <div>
              <div class="flex flex-row gap-2">
                <p class="font-roboto text-gray-500 p-1">{{ aboutus?.vision }}</p>
              </div>
            </div>
          </div>
          <img src="images/vision.jpg" class="w-full md:w-[40%] rounded-lg" alt="" />
        </div>
        <div class="w-full flex flex-col md:flex-row py-16 gap-8 mx-auto">
          <img
            src="images/mission.jpg"
            class="w-full md:w-[40%] hidden md:flex rounded-lg"
            alt=""
          />
          <div class="flex border border-gray-300 rounded-lg p-4 flex-col">
            <h1 class="font-bold text-2xl py-6 text-blue-900">Our Mission</h1>
            <div>
              <div class="flex flex-row gap-2">
                <p class="font-roboto text-gray-500 p-1">{{ aboutus?.mission }}</p>
              </div>
            </div>
          </div>
          <img
            src="images/mission.jpg"
            class="w-full md:w-[40%] md:hidden rounded-lg"
            alt=""
          />
        </div>
        <div class="w-full flex flex-col md:flex-row gap-8 mx-auto">
          <div class="flex border border-gray-300 rounded-lg p-4 flex-col">
            <h1 class="font-bold text-2xl py-6 text-blue-900">Our Goal</h1>
            <div>
              <div class="flex flex-row gap-2">
                <p class="font-roboto text-gray-500 p-1">{{ aboutus?.goal }}</p>
              </div>
            </div>
          </div>
          <img src="images/goal.jpg" class="w-full md:w-[40%] rounded-lg" alt="" />
        </div>
      </div>
    </div>
  </div>

  <div class="my-16">
    <ourTeam />
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
