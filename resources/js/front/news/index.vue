<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import Card from "./component/newsCard.vue";
import eventCard from "./component/eventCard.vue";
const perPage = ref(6);
const currentPage = ref(1);
const perevent = ref(8);
const currenteventpage = ref(1);

const allnews = ref([]);
const events = ref([]);
const keywords = ref("");

function gettingallnews() {
    axios
        .get("./api/news/getall")
        .then((res) => {
            allnews.value = res.data;
        })
        .catch((err) => {
            console.log(err);
        });
}

function getallevents() {
    axios
        .get("./api/event/getall")
        .then((res) => {
            events.value = res.data.events;
        })
        .catch((err) => console.log(err));
}

onMounted(() => {
    gettingallnews();
    getallevents();
});

const filterNews = computed(() => {
    const keyword = keywords.value.toLowerCase();
    if (keyword == "") {
        return allnews.value;
    } else {
        return allnews.value.filter((item) => item.title === keyword);
    }
});

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;
    return filterNews.value.slice(start, end);
});

const totalPages = computed(() =>
    Math.ceil(allnews.value.length / perPage.value)
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

const paginatevent = computed(() => {
    const start = (currenteventpage.value - 1) * perevent.value;
    const end = start + perevent.value;
    return events.value.slice(start, end);
});

const totaleventpages = computed(() =>
    Math.ceil(events.value.length / perevent.value)
);
const previouseventpage = () => {
    if (currenteventpage.value > 1) {
        currenteventpage.value--;
    }
};

const nexeventpage = () => {
    if (currenteventpage.value < totaleventpages.value) {
        currenteventpage.value++;
    }
};
</script>
<template>
    <div
        class="bg-gray-100 text-colorbackground w-[90%] sm:w-[80%] mx-auto font-body"
    >
        <div class="">
            <main class="py-6 bg-white">
                <div>
                    <div>
                        <div
                            class="flex border-b border-gray-200 justify-between"
                        >
                            <h3
                                class="font-bold sm:flex font-roboto text-darkred text-2xl mt-12"
                            >
                                News
                            </h3>
                            <h3
                                class="font-normal text-red-800 sm:flex font-roboto text-xl mt-12"
                            >
                                Latest News
                            </h3>
                        </div>

                        <!-- searching -->
                        <div class="max-w-xl mt-8 mx-auto">
                            <input
                                v-model="keywords"
                                name="time"
                                id="time"
                                class="bg-gray-50 border-4 shadow-lg border-blue-600 text-gray-900 text-sm rounded-2xl focus:ring-blue-500 focus:border-blue-500 w-full p-2 outline-none"
                                placeholder="search news here ..."
                            />
                        </div>

                        <div class="grid font-roboto md:grid-cols-3 sm:gap-4">
                            <div
                                class="mt-8"
                                v-for="news in paginatedData"
                                :key="news.id"
                            >
                                <Card :news="news" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div
                    class="mt-12 flex justify-center items-center gap-4 text-sm"
                >
                    <button
                        @click="prevPage"
                        :disabled="currentPage === 1"
                        class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 disabled:opacity-40 transition"
                    >
                        Previous
                    </button>

                    <span class="font-semibold text-lime-700">
                        Page {{ currentPage }} of {{ totalPages }}
                    </span>

                    <button
                        @click="nextPage"
                        :disabled="currentPage === totalPages"
                        class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 disabled:opacity-40 transition"
                    >
                        Next
                    </button>
                </div>
                <!-- pagination -->

                <div class=" ">
                    <div class="flex border-b border-gray-200 justify-between">
                        <h3
                            class="font-bold sm:flex my-8 font-roboto text-darkred text-2xl mt-12"
                        >
                            Events and Announcements
                        </h3>
                    </div>
                    <div
                        class="grid font-roboto md:grid-cols-3 lg:grid-cols-4 sm:gap-4"
                    >
                        <div
                            class="mt-8"
                            v-for="announcement in paginatevent"
                            :key="announcement.id"
                        >
                            <eventCard :announcement="announcement" />
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div
                    class="mt-12 flex justify-center items-center gap-4 text-sm"
                >
                    <button
                        @click="previouseventpage"
                        :disabled="currenteventpage === 1"
                        class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 disabled:opacity-40 transition"
                    >
                        Previous
                    </button>

                    <span class="font-semibold text-lime-700">
                        Page {{ currenteventpage }} of {{ totaleventpages }}
                    </span>

                    <button
                        @click="nexeventpage"
                        :disabled="currenteventpage === totaleventpages"
                        class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 disabled:opacity-40 transition"
                    >
                        Next
                    </button>
                </div>
                <!-- pagination -->
            </main>
        </div>
    </div>
</template>
