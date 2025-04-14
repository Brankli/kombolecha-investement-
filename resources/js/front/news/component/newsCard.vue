<script setup>
import { format, parseISO } from 'date-fns'
const props = defineProps({
    news:'',
})
const formatDate = (isoDateString) => {
    const date = parseISO(isoDateString);
    return format(date, 'yyyy-MM-dd');
};
</script>

<template>
    <router-link :to="{ name : 'getnewsDetail',params:{id:props.news.id}}">
        <div class="card hover:shadow-lg h-full flex flex-col">
            <img :src="props.news.image" class="w-full h-48 object-cover" alt="">
            <div class="m-4 flex-grow">
            <p class="py-2 text-sm font-normal text-gray-400">{{ props.news?.published_date }}, {{ props.news?.published_at }}</p>
            <span class="font-semibold text-md mt-12">{{ props.news.title.slice(0, 60) }}</span> <br />
            </div>
        </div>
    </router-link >
</template>