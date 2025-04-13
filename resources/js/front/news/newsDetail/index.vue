<script setup>
import sidebar from "../../components/sidebar.vue";
import newscontact from "./newscontact.vue";
import { format, parseISO } from "date-fns";
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";

// Router setup
const route = useRoute();
const router = useRouter();

const id = ref(route.params.id);
const news = ref("");
const contentarray = ref([]);
const infoarry = ref([]);

onMounted(() => {
    axios
        .get(`./api/news/edit/${id.value}`)
        .then((res) => {
            news.value = res.data.news;
            contentarray.value = news.value.content.split("#");
            infoarry.value = news.value.info.split("#");
        })
        .catch((err) => console.log(err));
});

// Back to previous page
const goBack = () => {
    router.back();
};

// Format date utility
const formatDate = (isoDateString) => {
    const date = parseISO(isoDateString);
    return format(date, "yyyy-MM-dd");
};
</script>

<template>
    <div class="bg-white font-roboto text-colorbackground">
        <div class="grid md:grid-cols-8">
            <main class="px-4 sm:px-16 py-6 bg-white md:col-span-5">
                <header>
                    <!-- Back Button -->
                    <div
                        class="flex items-center space-x-2 text-gray-700 cursor-pointer hover:text-gray-900"
                        @click="goBack"
                    >
                        <i class="fas fa-arrow-left text-xl"></i>
                        <span class="text-sm font-medium">Back</span>
                    </div>

                    <div>
                        <h4
                            class="font-light pb-2 mt-12 border-b border-gray-200"
                        ></h4>
                        <h2 class="text-lg text-gray-700 p-2 font-semibold">
                            {{ news.title }}
                        </h2>

                        <!-- News Image -->
                        <div
                            class="mt-8 bg-newsbackground grid lg:grid-cols-1 md:gap-10"
                        >
                            <div class="card mx-auto hover:shadow-lg">
                                <img
                                    :src="news.image"
                                    class="max-h-96 object-auto"
                                    alt=""
                                />
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="grid grid-cols-5 mt-8">
                            <div class="col-span-5 p-2 text-md text-gray-800">
                                <div v-for="con in contentarray" :key="con">
                                    <p>{{ con }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
            </main>

            <!-- Sidebar + Contact Info -->
            <div class="md:col-span-2 text-left">
                <div class="hidden md:flex mt-16"><sidebar /></div>
                <newscontact :info="infoarry" />
            </div>
        </div>
    </div>
</template>

<style scoped>
p {
    padding: 16px;
}
</style>
