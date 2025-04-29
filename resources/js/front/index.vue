<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";

import home from "./news/home.vue";
import partner from "./components/partner.vue";
import testimonial from "./components/testimonial.vue";
import banner from "./components/banner.vue";
import sidbar from "./components/sidebar.vue";
import recentevent from "./news/component/recentevent.vue";
import VisitTracker from "./VisitTracker.vue";

const preEvent = ref(7);
const currentEventPage = ref(1);
const events = ref([]);

onMounted(async () => {
    await axios
        .get("./api/event/getall")
        .then((res) => {
            events.value = res.data.events;
        })
        .catch((err) => console.log(err));
});

const paginateEvent = computed(() => {
    const start = (currentEventPage.value - 1) * preEvent.value;
    const end = start + preEvent.value;
    return events.value.slice(start, end);
});
</script>
<template>
    <div class="w-[90%] sm:w-[80%] mx-auto">
        <VisitTracker />
        <div class="mt-8">
            <div class="">
                <home />
            </div>
        </div>
        <div class="flex flex-col md:flex-row gap-4 my-16">
            <div>
                <h3
                    class="font-normal text-red-800 sm:flex font-roboto text-xl my-8"
                >
                    Events
                </h3>
                <div v-for="event in paginateEvent" :key="event">
                    <recentevent v-if="event.type == 'event'" :event="event" />
                </div>
            </div>

            <div>
                <h3
                    class="font-normal text-red-800 sm:flex font-roboto text-xl my-8"
                >
                    Announcements
                </h3>
                <div v-for="event in paginateEvent" :key="event">
                    <recentevent
                        v-if="event.type == 'announcment'"
                        :event="event"
                    />
                </div>
            </div>
        </div>
        <router-link
            to="/news"
            class="flex items-center w-fit border ml-4 border-yellow-600 rounded-md p-1 px-2 my-8 space-x-2 text-yellow-700 cursor-pointer hover:text-white hover:bg-yellow-700"
        >
            <i class="fas fa-arrow-right text-xl"></i>
            <span class="text-md font-bold">More Event</span>
        </router-link>
    </div>
    <div>
        <testimonial />
        <partner />
    </div>
</template>
