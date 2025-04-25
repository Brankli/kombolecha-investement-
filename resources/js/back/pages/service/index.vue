<script setup>
import axios from "axios";
import { onMounted, ref, computed } from "vue";
import name from "../../components/name.vue";
const services = ref([]);
const perPage = ref(5);
const currentPage = ref(1);

onMounted(async () => {
    await axios
        .get("./api/service/getall")
        .then((res) => {
            services.value = res.data.services;
        })
        .catch((err) => console.log(err));
});

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;
    return services.value.slice(start, end);
});

const totalPages = computed(() =>
    Math.ceil(services.value.length / perPage.value)
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
        <name name="Our Services" />
        <div class="m-4 mt-12 rounded">
            <div
                class="w-full bg-white border-b-2 rounded border-gray-200 flex flex-row justify-between"
            >
                <h1 class="font-bold text-gray-500 text-lg p-4 capitalize">
                    Service table
                </h1>
            </div>
            <!-- table start here -->
            <div class="flex bg-white flex-col items-center justify-center">
                <div
                    class="w-full relative p-2 overflow-x-auto shadow-md sm:rounded-lg xs:p-5"
                >
                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-500"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-3">Services</th>
                                <th scope="col" class="px-6 py-3">
                                    departments
                                </th>
                                <th scope="col" class="px-6 py-3">Edit</th>
                            </tr>
                        </thead>
                        <tbody
                            v-for="service in paginatedData"
                            :key="service.id"
                        >
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    {{ service.service.slice(0, 60) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ service.department.slice(0, 50) }}
                                </td>
                                <td class="px-6 py-4">
                                    <router-link
                                        :to="{
                                            name: 'editservice',
                                            params: { id: service.id },
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
