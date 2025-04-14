<script setup> 
import { format, parseISO } from "date-fns";
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";

const route = useRoute();
const router = useRouter();

const id = ref(route.params.id);
const event = ref("");
const eventparagraph = ref([]);
const info = ref([]);

onMounted(async () => {
    await axios
        .get(`./api/event/edit/${id.value}`)
        .then((res) => {
            event.value = res.data.event;
            eventparagraph.value = event.value.event.split("#");
            info.value = event.value.info.split("#");
        })
        .catch((err) => console.log(err));
});

const formatDate = (isoDateString) => {
    const date = parseISO(isoDateString);
    return format(date, "yyyy-MM-dd");
};

// Go back button
const goBack = () => {
    router.back();
};
</script>

<template>
    <div class="bg-white font-roboto text-colorbackground  overflow-hidden sm:w-[80%] mx-auto">
        <div class="">
            <main class="px-4 sm:px-16 py-6 bg-white md:col-span-5">
                <header>
                    <!-- Back Button -->
                    <div class="flex items-center my-8 space-x-2 text-gray-700 cursor-pointer hover:text-gray-900"
                        @click="goBack">
                        <i class="fas fa-arrow-left text-xl"></i>
                        <span class="text-sm font-medium">Back</span>
                    </div>

                    <div>
                        <h2 class="text-4xl text-gray-700 capitalize font-bold">
                            {{ event.type }}
                            <p class="py-2 text-sm font-normal text-gray-500">{{ event?.published_date  }}, {{ event?.published_at  }} </p> 
                        </h2>

                        <!-- Event Image --> 
                        <div class="mt-8">
                            <div class="mx-auto">
                                <img :src="event.image" class="w-full mx-auto object-contain " alt="" />
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="my-8">
                            <div class="text-md text-gray-800">
                                <div  class="preview ql-editor"  v-html="event?.event"> 
                                </div>
                            </div>
                        </div> 
                    </div>
                </header>
            </main>
        </div>
    </div>
</template>

<style scoped>
p {
    padding: 16px;
}
</style>
