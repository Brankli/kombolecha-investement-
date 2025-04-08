<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import sidbar from "./components/sidebar.vue"
import home from './news/home.vue';
import recentevent from "./news/component/recentevent.vue";
import banner from "./components/banner.vue";
const perevent = ref(7);
const currenteventpage = ref(1);
const events = ref([]);


onMounted(async() => {
    await axios.get('./api/event/getall').then(res => {
        events.value = res.data.events;
    }).catch(err => console.log(err));
})

const paginatevent = computed(() => {
    const start = (currenteventpage.value - 1) * perevent.value;
    const end = start + perevent.value;
    return events.value.slice(start, end);
});


</script>
<template>
    <div class="w-full h-fit">
        <banner />
    </div>
    <div class="grid sm:grid-cols-9 gap-8 mt-8 ">
        <div class="sm:cpl-span-1">
        </div>
        <div class="sm:col-span-5 border-b-2 border-gray-200">
            <home />
            <div class="text-end">
                <router-link to="/news"
                    class="bg-sky-700 hover:bg-sky-600 text-white p-2 text-xl rounded font-bold">More</router-link>
            </div>
        </div>
        <div class="hidden md:flex md:col-span-2">
            <sidbar />
        </div>
    </div>
    <div class="grid sm:grid-cols-9 gap-8">
        <div class="cpl-span-1">

        </div>
        <div class="sm:col-span-5 border-b-2 border-gray-200">
            <div class="w-full m-8 ml-0 border-b-2 border-gray-200">
                <h1 class=" text-darkred  p-4 border-b-4 border-darkred w-fit font-bold text-2xl">Announcments</h1>
            </div>
            <!-- recent list -->
            <div v-for="event in paginatevent" :key="event">
                <recentevent v-if="event.type == 'announcment'" :event="event" />
            </div>

            <div class="text-end">
                <router-link to="/news"
                    class="bg-sky-700 hover:bg-sky-600 text-white p-2 text-xl rounded font-bold">More</router-link>
            </div>
        </div>
        <div class="sm:col-span-2">
        </div>
    </div>
    <div class="grid sm:grid-cols-9 gap-8 mb-16">
        <div class="sm:col-span-1">

        </div>
        <div class="sm:col-span-5 border-b-2 border-gray-200">
            <div class="w-full  m-8 ml-0 border-b-2 border-gray-200">
                <h1 class=" text-darkred  p-4 border-b-4 border-darkred w-fit font-bold text-2xl">Events</h1>
            </div>
            <!-- recentlist -->

            <div v-for="event in paginatevent" :key="event">
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
</template>