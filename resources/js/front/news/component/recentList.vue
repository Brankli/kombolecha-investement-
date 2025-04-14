<script setup>
import { format, parseISO } from 'date-fns'
const props = defineProps({
    news:''
});
const formatDate = (isoDateString) => {
    const date = parseISO(isoDateString);
    return format(date, 'yyyy-MM-dd');
};
</script>

<template>
        <router-link :to="{ name: 'getnewsDetail', params: { id: props.news.id } }" >
    <div>
        <div class=" flex flex-row mb-5 hover:bg-gray-100 ml-4 ">
            <img :src="props.news.image" class="  w-20 h-20 ml-1 rounded-sm object-cover" alt="">
            <div class="">
                <h1 class="pl-4 text-md font-bold font-roboto text-gray-800">{{ props.news.title }}</h1>
                <p class="py-2 pl-4 text-sm font-normal text-blue-800">{{ props.news?.published_date  }}, {{ props.news?.published_at  }} </p>
            </div>
        </div>
    </div>
    </router-link>
</template>