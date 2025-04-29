<script setup>
import adminSidebar from "./components/adminSidebar.vue";
import adminHeader from "./components/adminHeader.vue";
import { onBeforeUnmount, onMounted, ref } from "vue";
import axios from "axios";
import { useLocalStorage } from "@vueuse/core";

const token = useLocalStorage("token", "");
const showSideBar = ref(false);
const user = ref("");
const collback = () => {
    showSideBar.value = !showSideBar.value;
};
const updateIsMobile = () => {
    showSideBar.value = true;
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

onBeforeUnmount(() => {
    window.removeEventListener("resize", updateIsMobile);
});
</script>
<template>
    <div v-if="token" class="flex flex-row fixed h-scree w-screen">
        <adminSidebar
            :user="user"
            @close-event="collback"
            :class="{
                'hidden md:flex': !showSideBar,
                flex: showSideBar,
            }"
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
