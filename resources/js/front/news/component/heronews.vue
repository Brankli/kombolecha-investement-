<script setup>
import { format, parseISO } from "date-fns";
const props = defineProps({
  news: "",
});
const formatDate = (isoDateString) => {
  const date = parseISO(isoDateString);
  return format(date, "yyyy-MM-dd");
};
</script>

<template>
  <router-link :to="{ name: 'getnewsDetail', params: { id: props.news.id } }">
    <div>
      <div class="card hover:shadow-lg">
        <img :src="props.news.image" class="w-full object-cover" alt="" />
        <div class="m-4">
          <span class="font-semibold font-roboto mt-12">{{ props.news.title }}</span>
          <br />
          <h2 class="text-gray-500 pt-4 text-sm">
            {{ formatDate(props.news.created_at) }}
          </h2>
          <p
            class="preview quil-editor pt-4 text-sm font-roboto tracking-wider"
            v-html="props.news.content.slice(0, 100) + '...'"
          ></p>
        </div>
      </div>
    </div>
  </router-link>
</template>
