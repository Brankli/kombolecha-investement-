<script setup>
import heronews from "./component/heronews.vue";
import recentListVue from "./component/recentList.vue";
import newsHeader from "./component/newsHeader.vue";
import { ref, onMounted, computed } from "vue";
import axios from "axios";
const allnews = ref([]);
const perPage = ref(3);
const currentPage = ref(1);
const prehero = ref("1");

const currenthero = ref(1);

function gettingallnews() {
  axios
    .get("./api/news/getall")
    .then((res) => {
      allnews.value = res.data;
    })
    .catch((err) => {
      console.log(err);
    });
}

onMounted(() => {
  gettingallnews();
});

const paginatedData = computed(() => {
  const start = (currentPage.value - 1) * perPage.value;
  const end = start + perPage.value;
  return allnews.value.slice(start, end);
});

const herodatapagination = computed(() => {
  const start = (currenthero.value - 1) * prehero.value;
  const end = start + prehero.value;
  return allnews.value.slice(start, end);
});
</script>
<template>
  <div class="m-8 ml-0 border-b-2 border-gray-100">
    <newsHeader />
  </div>
  <div class="grid lg:grid-cols-4 gap-4">
    <div class="lg:col-span-2">
      <div v-for="news in herodatapagination" :key="news.id">
        <heronews :news="news" />
      </div>
    </div>
    <div class="lg:col-span-2">
      <div v-for="news in paginatedData" :key="news.id">
        <recentListVue :news="news" />
      </div>
    </div>
  </div>
</template>
