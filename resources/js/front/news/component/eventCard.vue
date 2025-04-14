<script setup>
import { format, parseISO } from "date-fns";
const props = defineProps({
    announcement: "",
});
const formatDate = (isoDateString) => {
    const date = parseISO(isoDateString);
    return format(date, "yyyy-MM-dd");
};
</script>

<template>
    <router-link :to="{ name: 'geteventDetail', params: { id: props.announcement.id } }">
        <div
            class="rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden bg-white h-full flex flex-col">
            <div class="w-full">
                <div class="relative">
                    <img :src="props.announcement.image" alt="Event Image"
                        class="w-full h-40 sm:h-52 object-cover transition-transform duration-300" />

                    <div
                        class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300"> 
                        <span class="text-white text-base">
                            {{ props.announcement?.published_at  }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="p-4 flex-grow flex flex-col">
                <p class="py-2 text-sm font-normal text-blue-800">{{ props.announcement?.published_date }} </p>
                <p class="preview quil-editor text-lg font-semibold text-gray-800 leading-snug mt-2 flex-grow"
                    v-html="props.announcement.event.slice(0, 60) + '...'"></p>
            </div>
        </div>
    </router-link>
</template>
