<script setup>
import { format, parseISO } from 'date-fns'
const props = defineProps({
    announcement: '',
})
const formatDate = (isoDateString) => {
    const date = parseISO(isoDateString);
    return format(date, 'yyyy-MM-dd');
};
</script>

<template>
    <router-link :to="{ name: 'geteventDetail', params: { id: props.announcement.id } }">
        <div class="card hover:shadow-lg">
            <img :src="props.announcement.image" class="w-full h-32 sm:h-48 object-cover" alt="">
            <div class="m-4">
                <span class="block text-gray-500 text-md">{{ formatDate(props.announcement.created_at) }}</span> <br />
                <span class="font-semibold text-md  mt-12">{{ props.announcement.event.slice(0, 60) }}</span> <br />
            </div>
        </div>
    </router-link>
</template>