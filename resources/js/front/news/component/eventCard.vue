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
      class="rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden bg-white"
    >
      <!-- Full-Width Image Without Padding -->
      <div class="w-full">
        <img
          :src="props.announcement.image"
          alt="Event Image"
          class="w-full h-40 sm:h-52 object-cover transition-transform duration-300"
        />
      </div>

      <!-- Content -->
      <div class="p-4">
        <span class="text-gray-500 text-sm">
          {{ formatDate(props.announcement.created_at) }}
        </span>
        <p
          class="preview quil-editor text-lg font-semibold text-gray-800 leading-snug mt-2"
          v-html="props.announcement.event.slice(0, 60) + '...'"
        ></p>
      </div>
    </div>
  </router-link>
</template>
