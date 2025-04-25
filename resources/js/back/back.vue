<script setup>
import adminSidebar from "./components/adminSidebar.vue";
import adminHeader from "./components/adminHeader.vue";
import { onMounted, ref } from "vue";
import axios from "axios";
import { useLocalStorage } from "@vueuse/core";

const token = useLocalStorage("token", "");
const sidebarClass = ref("hidden");
const user = ref("");
const collback = () => {
    sidebarClass.value =
        sidebarClass.value === "hidden" ? "unhidden" : "hidden";
};

onMounted(async () => {
    axios.defaults.headers.common["Authorization"] = token.value;
    await axios
        .get(`./api/edit/user/1`)
        .then((res) => {
            user.value = res.data.user;
        })
        .catch((err) => console.log(err));
});
</script>
<template>
    <div v-if="token" class="flex flex-row fixed h-scree w-screen">
        <adminSidebar
            :user="user"
            @close-event="collback"
            :class="sidebarClass"
            class="lg:flex z-20 fixed h-screen"
        />
        <div class="w-full">
            <adminHeader :user="user" @close-event="collback" />

            <div class="overflow-y-auto max-h-[35rem] bg-gray-100">
                <router-view class="z-0" />
            </div>
        </div>
    </div>
</template>

<style>
.sidebarClass {
    z-index: 100;
}
</style>
