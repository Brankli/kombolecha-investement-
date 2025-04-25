<script setup>
import axios from "axios";
import { onMounted, ref, computed } from "vue";
import name from "../../components/name.vue";
import { useLocalStorage } from "@vueuse/core";
import { useAlertsStore } from "../../../store/useAlertsStore";

const alertstore = useAlertsStore();
const token = useLocalStorage("token", "");
const banners = ref([]);
const removedBannerId = ref([]);
const countBanners = ref(0);
const succ = ref("");
const err = ref("");
const perPage = ref(5);
const currentPage = ref(1);

function getbanners() {
    axios
        .get(`./api/getall/banner`)
        .then((res) => {
            banners.value = res.data;
        })
        .catch((err) => console.log(err));
}
onMounted(async () => {
    await getbanners();
});

function countTrashSponsers(id) {
    if (removedBannerId.value.includes(id)) {
        removedBannerId.value = removedBannerId.value.filter(
            (singleid) => singleid !== id
        );
        countBanners.value = removedBannerId.value.length;
    } else {
        removedBannerId.value.push(id);
        countBanners.value = removedBannerId.value.length;
    }
}

const hidenSponsor = () => {
    axios.defaults.headers.common["Authorization"] = token.value;
    axios
        .post(`./api/banner/hidden`, { id: removedBannerId.value })
        .then((res) => {
            alertstore.showSuccessToast(res.data.message);
            getbanners();
            setTimeout(() => {
                removedBannerId.value = "";
                countBanners.value = "";
            }, 2000);
        })
        .catch((error) => {
            alertstore.showErrortost(error.response.data.error);
        });
};

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;
    return banners.value.slice(start, end);
});

const totalPages = computed(() =>
    Math.ceil(banners.value.length / perPage.value)
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
</script>

<template>
    <div class="bg-gray-100 mb-24">
        <name name="Banners" />
        <div class="m-4 mt-12 rounded">
            <div
                class="w-full bg-white border-b-2 rounded border-gray-200 flex flex-row justify-between"
            >
                <h1 class="font-bold text-gray-500 text-lg p-4">Banner List</h1>
                <router-link
                    to="/banner"
                    class="w-fit text-white bg-sky-700 hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 m-4 text-center"
                    >add banner</router-link
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
                            <div v-if="countBanners" class="align-middle">
                                <p>
                                    <span
                                        class="text-blue-500 w-4 h-4 bg-gray-200 rounded-full p-2 font-bold"
                                        >{{ countBanners }}</span
                                    >
                                    banner selected
                                    <i
                                        @click.prevent="hidenSponsor"
                                        class="fas fa-trash text-xl font-extrabold w-10 h-10 hover:bg-gray-400 text-center p-2 bg-gray-200 rounded-full text-red-500"
                                    ></i>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4">
                        <div v-for="banner in paginatedData" :key="banner.id">
                            <div>
                                <img
                                    @click.prevent="
                                        countTrashSponsers(banner.id)
                                    "
                                    :class="
                                        removedBannerId.includes(banner.id)
                                            ? 'blur-md'
                                            : ''
                                    "
                                    :src="banner.image"
                                    class="w-48 h-48 rounded object-cover"
                                    alt="work-image"
                                />
                            </div>
                        </div>
                    </div>

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
