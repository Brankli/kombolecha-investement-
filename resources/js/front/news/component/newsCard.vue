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
        <div class="card hover:shadow-lg">
            <img :src="props.news.image" class="w-full h-32 sm:h-48 object-cover" alt="">
            <div class="m-4">
                <span class="block text-gray-500 text-sm">{{ formatDate(props.news.created_at) }}</span> <br />
                <span class="font-semibold text-sm  mt-12">{{ props.news.title.slice(0,60) }}</span> <br />
            </div>
        </div>
    </router-link >
</template>