<script setup>
import { ref } from "vue";
import axios from "axios";
import name from "../../components/name.vue";
import { useRouter } from "vue-router";
import { useLocalStorage } from "@vueuse/core";
import { useAlertsStore } from "../../../store/useAlertsStore";
const alertstore = useAlertsStore();
const token = useLocalStorage("token", "");

const title = ref("");
const discrption = ref("");
const order = ref(1);
const image = ref(null);
const router = useRouter();

// Handle image upload and store the file object
const handleImageUpload = (e) => {
    image.value = e.target.files[0]; // Store the file directly
};

const submitForm = async () => {
    axios.defaults.headers.common["Authorization"] = token.value;
    const formData = new FormData();
    formData.append("title", title.value);
    formData.append("description", discrption.value);
    formData.append("order", order.value);

    if (image.value) {
        formData.append("image", image.value); // Send the file
    }

    try {
        await axios.post("/api/store/sliders", formData); // Ensure you're sending FormData here
        router.push("/sliderindex");
    } catch (err) {
        console.error("Failed to create slider:", err);
    }
};
</script>

<template>
    <div class="min-h-screen bg-gray-50 mb-24">
        <name name="Add New Slider" />
        <div class="max-w-3xl mx-auto px-4 py-8">
            <div
                class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 md:p-8"
            >
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">
                        Create New Slider
                    </h2>
                    <p class="text-gray-500 mt-2">
                        Add a new slider to your website's hero section
                    </p>
                </div>

                <form @submit.prevent="submitForm" class="space-y-6">
                    <!-- Title Input -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >Slider Title
                            <span class="text-red-500">*</span></label
                        >
                        <input
                            v-model="title"
                            type="text"
                            required
                            placeholder="Enter slider title"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none"
                        />
                    </div>

                    <!-- Description Textarea -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >Description
                            <span class="text-red-500">*</span></label
                        >
                        <textarea
                            v-model="discrption"
                            required
                            rows="4"
                            placeholder="Write a short description..."
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 resize-none transition-all outline-none"
                        ></textarea>
                    </div>

                    <!-- Order Input -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >Display Order
                            <span class="text-red-500">*</span></label
                        >
                        <input
                            v-model="order"
                            type="number"
                            min="1"
                            required
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                        />
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >Slider Image
                            <span class="text-red-500">*</span></label
                        >
                        <div class="relative">
                            <input
                                type="file"
                                @change="handleImageUpload"
                                accept="image/*"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                id="fileInput"
                            />
                            <div class="flex items-center gap-4">
                                <label
                                    for="fileInput"
                                    class="px-6 py-2.5 bg-blue-50 text-blue-700 rounded-lg border border-blue-200 hover:bg-blue-100 transition-colors cursor-pointer"
                                >
                                    Choose File
                                </label>
                                <span
                                    class="text-gray-500 text-sm"
                                    v-if="image"
                                    >{{ image.name }}</span
                                >
                                <span class="text-gray-400 text-sm" v-else
                                    >No file chosen</span
                                >
                            </div>
                        </div>
                        <p class="text-gray-400 text-sm mt-2"></p>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6 border-t border-gray-100">
                        <button
                            type="submit"
                            class="w-full md:w-auto px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all shadow-sm hover:shadow-md"
                        >
                            Create Slider
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
