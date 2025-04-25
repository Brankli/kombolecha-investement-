<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";

const emit = defineEmits(["closeEvent"]);
const showSidebar = ref(false);
const isMobile = ref(false);

const items = ref([
    { to: "/dashbord", icon: "home", label: "Dashboard" },
    { to: "/newspage", icon: "newspaper", label: "News" },
    { to: "/content", icon: "tv", label: "Content" },
    { to: "/ourwork", icon: "list-check", label: "Our Works" },
    { to: "/services", icon: "chart-line", label: "Services" },
    { to: "/channels", icon: "file", label: "Channels" },
    { to: "/sponsers", icon: "handshake", label: "Partners" },
    { to: "/newtestimonial", icon: "comment", label: "Testimonies" },
    { to: "/staff", icon: "paper-plane", label: "Staff" },
    { to: "/sliderindex", icon: "image", label: "Slider" },
]);

const toggleSidebar = () => {
    showSidebar.value = !showSidebar.value;
    emit("closeEvent", showSidebar.value);
};

const onLinkClick = () => {
    if (isMobile.value && showSidebar.value) {
        toggleSidebar();
    }
};

const updateIsMobile = () => {
    isMobile.value = window.innerWidth < 768;
};

onMounted(() => {
    updateIsMobile();
    window.addEventListener("resize", updateIsMobile);
});

onBeforeUnmount(() => {
    window.removeEventListener("resize", updateIsMobile);
});

defineProps({ user: Object });
</script>

<template>
    <!-- Sidebar wrapper: fixed width to prevent shrink effect -->
    <div class="fixed md:relative z-50 bg-darkblue min-h-screen w-72 mb-24">
        <!-- Mobile hamburger -->
        <div class="md:hidden p-2">
            <font-awesome-icon
                @click.prevent="toggleSidebar"
                :icon="showSidebar ? 'xmark' : 'bars'"
                class="text-white text-2xl cursor-pointer"
            />
        </div>

        <!-- Slide-in Sidebar Panel -->
        <transition name="slide">
            <div
                v-show="showSidebar || !isMobile"
                :class="[
                    'bg-darkblue text-cyan-100 w-72 space-y-6 px-4 py-4 fixed md:relative inset-y-0 left-0 transition-transform duration-200 ease-out z-40',
                    showSidebar || !isMobile
                        ? 'translate-x-0'
                        : '-translate-x-full',
                ]"
            >
                <!-- Nav Links -->
                <nav class="overflow-y-auto h-[calc(100vh-6rem)] space-y-1">
                    <router-link
                        v-for="item in items"
                        :key="item.to"
                        :to="item.to"
                        @click="onLinkClick"
                        class="flex items-center space-x-2 py-3 px-4 hover:bg-cyan-700 rounded hover:text-cyan-300 transition"
                    >
                        <font-awesome-icon
                            :icon="item.icon"
                            class="text-white"
                        />
                        <span class="text-xl font-semibold">{{
                            item.label
                        }}</span>
                    </router-link>
                </nav>
            </div>
        </transition>
    </div>
</template>

<style scoped>
.slide-enter-from,
.slide-leave-to {
    transform: translateX(-100%);
}
.slide-enter-active,
.slide-leave-active {
    transition: transform 0.2s ease;
}
</style>
