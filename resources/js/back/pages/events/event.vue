<script setup>
import axios from "axios";
import { onMounted, ref, computed } from "vue";
import { format, parseISO } from 'date-fns'
import { useLocalStorage } from "@vueuse/core";
import succs from "../conformation/succ.vue";
import errs from "../conformation/err.vue";
const token = useLocalStorage('token', '');
const events = ref([]);
const deletedevetId = ref([]);
const deletecountevent = ref(0);

const succ = ref('');
const err = ref('');

const perPage = ref(5);
const currentPage = ref(1);
const keywords = ref('');

onMounted(async () => {
    await axios.get('./api/event/getall').then(res => {
        events.value = res.data.events;
    }).catch(err => console.log(err));
});

function counthidentrash(id) {
    if (deletedevetId.value.includes(id)) {
        deletedevetId.value = deletedevetId.value.filter(singleid => singleid !== id);
        deletecountevent.value = deletedevetId.value.length;
    } else {
        deletedevetId.value.push(id);
        deletecountevent.value = deletedevetId.value.length;
    }
}

const hidentrash = () => {
    axios.defaults.headers.common['Authorization'] = token.value;
    axios.post('./api/event/hidden', { id: deletedevetId.value }).then(res => {
        return succ.value = res.data.message;
    }).catch(error => {
        return err.value = error.data.message;
    })
}


const searching = computed(() => {
    const keyword = keywords.value.toLocaleLowerCase();
    return events.value.filter(item => item.event.toLowerCase().includes(keyword));
});


const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;
    return searching.value.slice(start, end);
});

const totalPages = computed(() => Math.ceil(searching.value.length / perPage.value));
const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};
const formatDate = (isoDateString) => {
    const date = parseISO(isoDateString);
    return format(date, 'yyyy-MM-dd');
};
</script>

<template>
    <succs v-if="succ" :succ="succ" />
    <errs v-if="err" :err="err" />
    <div class="w-full bg-white border-b-2 rounded border-gray-200 flex flex-row justify-between">
        <h1 class="font-bold text-gray-500 text-lg p-4 ">Events table</h1>
        <router-link to="/eventannauncer"
            class="w-24 text-white bg-sky-700 hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 m-4 text-center ">Post</router-link>
    </div>
    <div class="flex bg-white flex-col items-center justify-center">
        <div class=" w-full  relative p-2 overflow-x-auto shadow-md sm:rounded-lg xs:p-5">
            <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
                <div>
                    <div v-if="deletecountevent" class="align-middle">
                        <p><span class="text-blue-500 w-4 h-4 bg-gray-200 rounded-full p-2 font-bold">{{ deletecountevent
                        }}</span> row selected <i @click.prevent="hidentrash"
                                class="material-icons text-xl font-extrabold w-10 h-10 hover:bg-gray-400 text-center p-2 bg-gray-200 rounded-full text-red-500">delete</i>
                        </p>
                    </div>
                </div>
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div
                        class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input v-model="keywords" @input="searching" type="text" id="table-search"
                        class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-sky-500 focus:border-sky-500 outline-none"
                        placeholder="Search for items">
                </div>
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="p-4">
                            mark
                        </th>
                        <th scope="col" class="px-6 py-3">
                            News title
                        </th>
                        <th scope="col" class="px-6 py-3">
                            News content
                        </th>
                        <th scope="col" class="px-6 py-3">
                            additional info
                        </th>
                        <th scope="col" class="px-6 py-3">
                            News created_at
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Edit
                        </th>
                    </tr>
                </thead>
                <tbody v-for="event in paginatedData" :key="event.id">
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td @click.prevent="counthidentrash(event.id)" class="w-4 p-4">
                            <div class="border-4 border-gray-200 text-center rounded w-5 h-5">
                                <p v-if="deletedevetId.includes(event.id)"><i
                                        class="material-icons text-2xl font-bold text-green-600">done</i></p>
                            </div>
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            <img :src="event.image" class="w-16 h-10 object-cover" alt="work-image">
                        </th>
                        <td  class=" preview quil-editor  px-6 py-4 " v-html="event.event">
                          
                        </td>
                        <td class="px-6 py-4">
                            {{ event.type.slice(0, 10) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ formatDate(event.created_at) }}
                        </td>
                        <td class="px-6 py-4">
                            <router-link :to="{ name: 'editevent', params: { id: event.id } }"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-if="perPage >= 5" class="w-full justify-between flex flex-row pt-4">
                <div><button
                        class="shadow p-2 bg-gray-200 active:text-red-500 hover:bg-gray-300 text-briteblue text-lg font-bold rounded"
                        @click="prevPage" :disabled="currentPage === 1">Back</button></div>
                <div><span class=" p-2 bg-gray-200 text-lg font-bold rounded">{{ currentPage }}</span></div>
                <div><button
                        class="shadow p-2 bg-gray-200 active:text-red-500 text-briteblue hover:bg-gray-300 text-lg font-bold rounded"
                        @click="nextPage" :disabled="currentPage === totalPages">Next</button></div>
        </div>
    </div>
</div></template>
