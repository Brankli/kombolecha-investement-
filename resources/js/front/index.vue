<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";

import home from './news/home.vue';
import partner from "./components/partner.vue";
import testimonial from "./components/testimonial.vue";
import banner from "./components/banner.vue";
import sidbar from "./components/sidebar.vue";
import recentevent from "./news/component/recentevent.vue";


const preEvent = ref(7);
const currentEventPage = ref(1);
const events = ref([]);


onMounted(async () => {
    await axios.get('./api/event/getall').then(res => {
        events.value = res.data.events;
    }).catch(err => console.log(err));
})

const paginateEvent = computed(() => {
    const start = (currentEventPage.value - 1) * preEvent.value;
    const end = start + preEvent.value;
    return events.value.slice(start, end);
});


</script>
<template> 
    <div class="w-[90%] sm:w-[80%] mx-auto">
        <div class=" mt-8">
            <div class="">
                <home />
            </div>
        </div>

        <div class=""> 
            <div class="">
                <div class="w-full m-8 ml-0 ">
                    <h1 class=" text-darkred  p-4 border-b-4 border-darkred w-fit font-bold text-2xl">Announcments</h1>
                </div>
                <!-- recent list -->
                <div v-for="event in paginateEvent" :key="event">
                    <recentevent v-if="event.type == 'announcment'" :event="event" />
                </div>
            </div>
            <div class="sm:col-span-2">
            </div>
        </div>
        <div class=" mb-16">
            <div class="sm:col-span-1">

            </div>
            <div class="">
                <div class="w-full  m-8 ml-0 ">
                    <h1 class=" text-darkred  p-4 border-b-4 border-darkred w-fit font-bold text-2xl">Events</h1>
                </div>
                <!-- recentlist -->

                <div v-for="event in paginateEvent" :key="event">
                    <recentevent v-if="event.type == 'event'" :event="event" />
                </div>

                <div class="text-end ">
                    <router-link to="/news"
                        class="bg-sky-700 hover:bg-sky-600 text-white p-2 text-xl rounded font-bold">More</router-link>
                </div>
            </div>
            <div class="sm:col-span-2 ">
            </div>
        </div>

    </div>
    <div>
        <testimonial />
        <partner />
    </div>
</template>