<script setup>
import { format, parseISO } from "date-fns";
const props = defineProps({
    event: "",
});
const formatDate = (isoDateString) => {
    const date = parseISO(isoDateString);
    return format(date, "yyyy-MM-dd");
};
</script>

<template>
    <router-link :to="{ name: 'geteventDetail', params: { id: props.event.id } }">
        <div>
            <div class="flex flex-row mb-5 hover:bg-gray-100">
                <img :src="props.event.image" class="w-20 rounded-sm h-20 ml-1 object-cover" alt="" />
                <div class="">
                    <p class="pl-4 text-md font-bold font-roboto text-gray-800"
                        v-html="props.event.event.slice(0, 100) + '...'">
                    </p>
                    <p class="py-2 pl-4 text-sm font-normal text-blue-800">{{ props.event?.published_date }}, {{
                        props.event?.published_at }} </p>
                </div>
            </div>
        </div>
    </router-link>
</template>
