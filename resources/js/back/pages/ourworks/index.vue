<script setup>
import axios from "axios";
import { onMounted, ref, computed } from "vue";
import { format, parseISO } from "date-fns";
import name from "../../components/name.vue";
import { useLocalStorage } from "@vueuse/core";

import { useAlertsStore } from "../../../store/useAlertsStore";

const alertStore = useAlertsStore();
const token = useLocalStorage("token", "");
const PreviousWorks = ref([]);
const hiddenworks = ref([]);
const counthiddenwork = ref(0);
const succ = ref("");
const err = ref("");
const perPage = ref(5);
const currentPage = ref(1);
const keywords = ref("");

onMounted(async () => {
    await axios
        .get("./api/getall/PreviousWork")
        .then((res) => {
            PreviousWorks.value = res.data;
        })
        .catch((err) => console.log(err));
});

function hideworktotrash(id) {
    if (hiddenworks.value.includes(id)) {
        hiddenworks.value = hiddenworks.value.filter(
            (singleid) => singleid !== id
        );
        counthiddenwork.value = hiddenworks.value.length;
    } else {
        hiddenworks.value.push(id);
        counthiddenwork.value = hiddenworks.value.length;
    }
}

const removetrash = () => {
    axios.defaults.headers.common["Authorization"] = token.value;
    axios
        .post("./api/work/hidden", { id: hiddenworks.value })
        .then((res) => {
            alertStore.showSuccessToast(res.data.message);
            setTimeout(() => {
                hiddenworks.value = "";
                counthiddenwork.value = "";
            }, 2000);
        })
        .catch((error) => {
            alertStore.showErrortost(error.response.data.error);
        });
};

const searching = computed(() => {
    const keyword = keywords.value.toLocaleLowerCase();
    return PreviousWorks.value.filter((item) =>
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
    <div class="bg-gray-100 mb-24">
        <name name="Our Works" />
        <succs v-if="succ" :succ="succ" />
        <errs v-if="err" :err="err" />
        <div class="m-4 rounded">
            <div
                class="w-full bg-white border-b-2 rounded border-gray-200 flex flex-row justify-between"
            >
                <h1 class="font-bold text-gray-500 text-lg p-4">
                    Our Previous Work
                </h1>
                <router-link
                    to="/postwork"
                    class="w-fit text-white bg-sky-700 hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 m-4 text-center"
                    >add portfolio</router-link
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
                            <div v-if="counthiddenwork" class="align-middle">
                                <p>
                                    <span
                                        class="text-blue-500 w-4 h-4 bg-gray-200 rounded-full p-2 font-bold"
                                        >{{ counthiddenwork }}</span
                                    >
                                    row selected<i
                                        @click.prevent="removetrash"
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
                            class="text-xs text-gray-700 uppercase bg-gray-50"
                        >
                            <tr>
                                <th scope="col" class="p-4">mark</th>
                                <th scope="col" class="px-6 py-3">image</th>
                                <th scope="col" class="px-6 py-3">title</th>
                                <th scope="col" class="px-6 py-3">sector</th>
                                <th scope="col" class="px-6 py-3">date</th>
                                <th scope="col" class="px-6 py-3">Edit</th>
                            </tr>
                        </thead>
                        <tbody
                            v-for="PreviousWork in paginatedData"
                            :key="PreviousWork.id"
                        >
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td
                                    @click.prevent="
                                        hideworktotrash(PreviousWork.id)
                                    "
                                    class="w-4 p-4"
                                >
                                    <div
                                        class="border-4 border-gray-200 text-center rounded w-5 h-5"
                                    >
                                        <p
                                            v-if="
                                                hiddenworks.includes(
                                                    PreviousWork.id
                                                )
                                            "
                                        >
                                            <i
                                                class="fas fa-check text-2xl font-bold text-green-600"
                                            ></i>
                                        </p>
                                    </div>
                                </td>
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                >
                                    <img
                                        :src="PreviousWork.image"
                                        class="w-16 h-10 object-cover"
                                        alt="work-image"
                                    />
                                </th>
                                <td class="px-6 py-4">
                                    {{ PreviousWork.title.slice(0, 60) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ PreviousWork.category.slice(0, 50) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ formatDate(PreviousWork.created_at) }}
                                </td>
                                <td class="px-6 py-4">
                                    <router-link
                                        :to="{
                                            name: 'editwork',
                                            params: { id: PreviousWork.id },
                                        }"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                        ><i
                                            class="fas fa-edit text-xl font-extrabold w-10 h-10 hover:bg-gray-400 text-center p-2 bg-gray-200 rounded-full text-red-500"
                                        ></i>
                                    </router-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div
                        v-if="perPage >= 5"
                        class="w-full justify-center gap-2 flex flex-row pt-4"
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
                            <button
                                class="shadow p-2 bg-gray-200 text-briteblue hover:bg-gray-300 text-lg font-bold rounded"
                            >
                                page {{ currentPage }}
                            </button>
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
        </div>
    </div>
</template>
