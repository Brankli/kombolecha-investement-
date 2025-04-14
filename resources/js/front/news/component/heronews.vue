<script setup>
import { format, parseISO } from "date-fns";
const props = defineProps({
  news: "",
}); 
</script>

<template>
  <router-link :to="{ name: 'getnewsDetail', params: { id: props.news.id } }">
    <div>
      <div class="card hover:shadow-lg">
        <img :src="props.news.image" class="w-full object-cover" alt="" />
        <div class="m-4">
          <p class="py-2 text-sm font-normal text-blue-800">{{ props.news?.published_date  }}, {{ props.news?.published_at  }} </p>
          <h1 class="font-semibold text-xl font-roboto mt-4">{{ props.news.title }}</h1>
          <p
            class="preview ql-editor pt-4 text-sm font-roboto tracking-wider"
            v-html="props.news.content.slice(0, 100) + '...'"
          ></p>
        </div>
      </div>
    </div>
  </router-link>
</template>
