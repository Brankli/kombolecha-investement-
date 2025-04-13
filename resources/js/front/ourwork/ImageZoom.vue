<script setup>
import { defineEmits, defineProps } from "vue";

const emit = defineEmits(["someEvent"]);
const props = defineProps({
    zoomImage: {
        type: String,
        required: true,
    },
    title: {
        type: String,
        default: "Project Title",
    },
    category: {
        type: String,
        default: "Category",
    },
    description: {
        type: String,
        default: "No description available.",
    },
});

// close when backdrop or close button clicked
const closeZoom = () => {
    emit("someEvent");
};
</script>

<template>
    <!-- backdrop: click.self so clicking image/details won't close -->
    <div
        @click.self="closeZoom"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 p-4 overflow-y-auto"
    >
        <div
            class="relative w-full max-w-3xl bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300"
        >
            <!-- Close button -->
            <button
                @click="closeZoom"
                class="absolute top-3 right-3 text-white bg-black bg-opacity-50 rounded-full p-1 hover:bg-opacity-75 transition"
                aria-label="Close"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                >
                    <path
                        fill-rule="evenodd"
                        d="M10 8.586l4.95-4.95a1 1 0 111.414 1.414L11.414 10l4.95 
               4.95a1 1 0 11-1.414 1.414L10 11.414l-4.95 4.95a1 1 0 
               11-1.414-1.414L8.586 10l-4.95-4.95a1 1 0 
               011.414-1.414L10 8.586z"
                        clip-rule="evenodd"
                    />
                </svg>
            </button>

            <!-- Image -->
            <img
                :src="props.zoomImage"
                alt="Zoomed Image"
                class="w-full h-auto object-contain bg-black"
            />

            <!-- Details Panel -->
            <!-- <div class="p-6 space-y-2">
                <h2 class="text-2xl font-bold text-gray-800">
                    {{ props.title }}
                </h2>
                <p class="text-sm text-gray-500 uppercase">
                    {{ props.category }}
                </p>
                <p class="text-gray-700">{{ props.description }}</p>
            </div> -->
        </div>
    </div>
</template>
