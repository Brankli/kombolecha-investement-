<script setup>
import { ref } from "vue";
import headerdropdown from "./headerdropdown.vue";
import adminSidebar from "./adminSidebar.vue";

const dropdownClass = ref("hidden");
const emit = defineEmits(["closeEvent"]);

const props = defineProps({
    user: Object,
});

const handleevent = () => {
    emit("closeEvent");
};

const toggledropdown = () => {
    dropdownClass.value = dropdownClass.value === "hidden" ? "block" : "hidden";
};
</script>

<template>
    <div
        class="w-full border-b-2 border-gray-200 shadow-lg bg-white sticky top-0 z-40"
    >
        <div
            class="flex flex-row justify-between md:justify-end items-center px-4 py-2"
        >
            <!-- Sidebar Toggle (Mobile Only) -->
            <div class="lg:hidden">
                <i
                    @click.prevent="handleevent"
                    class="fas fa-bars text-darkblue text-2xl cursor-pointer"
                ></i>
            </div>

            <!-- User Info Section -->
            <div class="flex items-center gap-4">
                <img
                    v-if="props.user?.image"
                    :src="props.user.image"
                    class="h-10 w-10 object-cover border-2 border-sky-800 rounded-full"
                    alt="admin profile"
                />
                <div class="hidden sm:block">
                    <h1 class="text-darkblue font-bold text-md capitalize">
                        {{ props.user?.name }}
                    </h1>
                    <p class="text-sm text-gray-600">
                        {{ props.user?.phone_no }}
                    </p>
                </div>

                <!-- Dropdown Button -->
                <div class="relative">
                    <button
                        @click.prevent="toggledropdown"
                        class="inline-flex items-center gap-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow ring-1 ring-gray-300 hover:bg-gray-100"
                    >
                        Options
                        <i class="fas fa-chevron-down text-gray-600"></i>
                    </button>

                    <!-- Dropdown Component -->
                    <headerdropdown
                        @close-event="toggledropdown"
                        :class="`${dropdownClass} absolute right-0 mt-2 z-10`"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Ensure dropdown appears on top of content */
headerdropdown {
    min-width: 150px;
}
</style>
