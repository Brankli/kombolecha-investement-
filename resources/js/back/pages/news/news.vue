<script setup>
import axios from "axios";
import { onMounted, ref, computed } from "vue";
import { format, parseISO } from "date-fns";
import name from "../../components/name.vue";
import event from "../events/event.vue";
import succs from "../conformation/succ.vue";
import errs from "../conformation/err.vue";
import { useLocalStorage } from "@vueuse/core";

const token = useLocalStorage("token", "");
const allnews = ref([]);
const dletedId = ref([]);
const dletecound = ref(0);
const succ = ref("");
const err = ref("");
const perPage = ref(5);
const currentPage = ref(1);
const keywords = ref("");

function gettingallnews() {
    axios
        .get("./api/news/getall")
        .then((res) => {
            allnews.value = res.data;
        })
        .catch((err) => {
            console.log("hdjfdjh");
        });
}

onMounted(async () => {
    gettingallnews();
});

function countandtrash(id) {
    if (dletedId.value.includes(id)) {
        dletedId.value = dletedId.value.filter((singleid) => singleid !== id);
        dletecound.value = dletedId.value.length;
    } else {
        dletedId.value.push(id);
        dletecound.value = dletedId.value.length;
    }
}

const hidennews = () => {
    axios.defaults.headers.common["Authorization"] = token.value;
    axios
        .post("./api/hidden", { id: dletedId.value })
        .then((res) => {
            succ.value = res.data.message;
            gettingallnews();
        })
        .catch((error) => {
            return (err.value = error.data.message);
        });
};

const searching = computed(() => {
    const keyword = keywords.value.toLocaleLowerCase();
    return allnews.value.filter((item) =>
        item.title.toLowerCase().includes(keyword)
    );
});

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;
    return searching.value.slice(start, end);
});

const totalPages = computed(() =>
    Math.ceil(searching.value.length / perPage.value)
);
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
    return format(date, "yyyy-MM-dd");
};
</script>

<template>
    <div class="bg-gray-100">
        <name name="news and events" />
        <succs v-if="succ" :succ="succ" />
        <errs v-if="err" :err="err" />
        <div class="m-4 rounded">
            <div
                class="w-full bg-white border-b-2 rounded border-gray-200 flex flex-row justify-between"
            >
                <h1 class="font-bold text-gray-500 text-lg p-4 capitalize">
                    News table
                </h1>
                <router-link
                    to="/post"
                    class="w-24 text-white bg-sky-700 hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 m-4 text-center"
                    >Post</router-link
                >
            </div>

            <!-- table start here -->
            <div class="flex bg-white flex-col items-center justify-center">
                <div
                    class="w-full relative p-2 overflow-x-auto shadow-md sm:rounded-lg xs:p-5"
                >
                    <div
                        class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4"
                    >
                        <div>
                            <div v-if="dletecound" class="align-middle">
                                <p>
                                    <span
                                        class="text-blue-500 w-4 h-4 bg-gray-200 rounded-full p-2 font-bold"
                                        >{{ dletecound }}</span
                                    >
                                    row selected
                                    <i
                                        @click.prevent="hidennews"
                                        class="fas fa-trash text-xl font-extrabold w-10 h-10 hover:bg-gray-400 text-center p-2 bg-gray-200 rounded-full text-red-500"
                                    ></i>
                                </p>
                            </div>
                        </div>
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none"
                            >
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <input
                                v-model="keywords"
                                @input="searching"
                                type="text"
                                id="table-search"
                                class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-sky-500 focus:border-sky-500 outline-none"
                                placeholder="Search for items"
                            />
                        </div>
                    </div>
                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-500"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-100"
                        >
                            <tr>
                                <th scope="col" class="p-3 w-6">Mark</th>
                                <th scope="col" class="px-3 py-2 w-40">
                                    Title
                                </th>
                                <th scope="col" class="px-4 py-2 w-[60%]">
                                    Content
                                </th>
                                <th scope="col" class="px-3 py-2 w-6">
                                    Created At
                                </th>
                                <th scope="col" class="px-4 py-2 w-6">
                                    Action
                                </th>
                            </tr>
                        </thead>

                        <tbody v-for="news in paginatedData" :key="news.id">
                            <tr
                                v-if="news"
                                class="bg-white border-b hover:bg-gray-50"
                            >
                                <td
                                    @click.prevent="countandtrash(news.id)"
                                    class="p-3 text-center"
                                >
                                    <div
                                        class="border-2 border-gray-300 rounded w-5 h-5 mx-auto"
                                    >
                                        <p v-if="dletedId.includes(news.id)">
                                            <i
                                                class="fas fa-check text-2xl font-bold text-green-600"
                                            ></i>
                                        </p>
                                    </div>
                                </td>
                                <td
                                    class="px-3 py-2 text-gray-900 font-semibold max-w-[140px]"
                                >
                                    <span
                                        class="block truncate text-sm leading-tight"
                                        :title="news.title"
                                    >
                                        {{ news.title }}
                                    </span>
                                </td>

                                <td class="px-4 py-2 align-top">
                                    <div
                                        class="preview quil-editor max-h-40 overflow-y-auto text-gray-700 text-sm leading-relaxed whitespace-pre-line border p-2 rounded bg-gray-50"
                                        v-html="news.content"
                                    ></div>
                                </td>

                                <td class="px-3 py-2 text-gray-600">
                                    {{ formatDate(news.created_at) }}
                                </td>
                                <td class="px-4 py-2">
                                    <router-link
                                        :to="{
                                            name: 'edit',
                                            params: { id: news.id },
                                        }"
                                        class="text-blue-600 hover:text-blue-800"
                                    >
                                        <i
                                            class="fas fa-edit text-lg bg-gray-200 p-2 rounded-full hover:bg-gray-300"
                                        ></i>
                                    </router-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div
                        v-if="perPage > 4"
                        class="w-full justify-between flex flex-row pt-4"
                    >
                        <div>
                            <button
                                class="shadow p-2 bg-gray-200 active:text-red-500 hover:bg-gray-300 text-briteblue text-lg font-bold rounded"
                                @click="prevPage"
                                :disabled="currentPage === 1"
                            >
                                Back
                            </button>
                        </div>
                        <div>
                            <span
                                class="p-2 bg-gray-200 text-lg font-bold rounded"
                                >{{ currentPage }}</span
                            >
                        </div>
                        <div>
                            <button
                                class="shadow p-2 bg-gray-200 active:text-red-500 text-briteblue hover:bg-gray-300 text-lg font-bold rounded"
                                @click="nextPage"
                                :disabled="currentPage === totalPages"
                            >
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- events -->

            <div class="mt-16">
                <event />
            </div>
        </div>
    </div>
</template>
