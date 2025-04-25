<script setup>
import axios from "axios";
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import name from "../../components/name.vue";
import { useLocalStorage } from "@vueuse/core";
import { useAlertsStore } from "../../../store/useAlertsStore";

const alertstore = useAlertsStore();
const router = useRouter();
const token = useLocalStorage("token", "");

// Data lists + pagination + search
const testimonials = ref([]);
const keywords = ref("");
const perPage = ref(5);
const currentPage = ref(1);

// Bulk select
const removedTestimonialsId = ref([]);
const contTestimonials = ref(0);

// Modal state
const showModal = ref(false);
const selected = ref({
    id: null,
    Name: "",
    discribution: "",
    image: null, // existing image path
    newImage: null, // File object
    preview: null, // URL for preview
});

// Fetch all testimonials
async function fetchAll() {
    try {
        const res = await axios.get("./api/getall/testimonial", {
            headers: { Authorization: token.value },
        });
        testimonials.value = res.data;
    } catch (err) {
        console.error(err);
    }
}

onMounted(fetchAll);

// Bulk hide
function countSelect(id) {
    const idx = removedTestimonialsId.value.indexOf(id);
    if (idx > -1) removedTestimonialsId.value.splice(idx, 1);
    else removedTestimonialsId.value.push(id);
    contTestimonials.value = removedTestimonialsId.value.length;
}

async function hideSelected() {
    try {
        await axios.delete("./api/testimonial/hidden", {
            headers: { Authorization: token.value },
            data: { id: removedTestimonialsId.value },
        });
        alertstore.showSuccessToast("Hidden successfully");
        testimonials.value = testimonials.value.filter(
            (t) => !removedTestimonialsId.value.includes(t.id)
        );
        removedTestimonialsId.value = [];
        contTestimonials.value = 0;
    } catch (e) {
        alertstore.showErrortost(e.message);
    }
}

// Delete single
async function deleteTestimonial(id) {
    if (!confirm("Delete testimonial?")) return;
    try {
        await axios.delete(`./api/testimonial/${id}`, {
            headers: { Authorization: token.value },
        });
        alertstore.showSuccessToast("Deleted successfully");
        testimonials.value = testimonials.value.filter((t) => t.id !== id);
    } catch (e) {
        alertstore.showErrortost(e.message);
    }
}

// Open Edit Modal
function openEdit(t) {
    selected.value.id = t.id;
    selected.value.Name = t.Name;
    selected.value.discribution = t.discribution;
    selected.value.image = t.image;
    selected.value.preview = null;
    selected.value.newImage = null;
    showModal.value = true;
}

// Handle image change
function onImageChange(e) {
    const file = e.target.files[0];
    if (!file) return;
    selected.value.newImage = file;
    selected.value.preview = URL.createObjectURL(file);
}

// Save edits
async function saveEdit() {
    const form = new FormData();
    form.append("Name", selected.value.Name);
    form.append("discribution", selected.value.discribution);
    if (selected.value.newImage) {
        form.append("image", selected.value.newImage);
    }
    try {
        await axios.post(`./api/testimonial/${selected.value.id}`, form, {
            headers: {
                Authorization: token.value,
                "Content-Type": "multipart/form-data",
            },
        });
        alertstore.showSuccessToast("Updated successfully");
        showModal.value = false;
        fetchAll();
    } catch (e) {
        alertstore.showErrortost(e.message);
    }
}

// Search & pagination
const filtered = computed(() => {
    const kw = keywords.value.toLowerCase();
    return testimonials.value.filter((t) => t.Name.toLowerCase().includes(kw));
});
const paginated = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    return filtered.value.slice(start, start + perPage.value);
});
const totalPages = computed(() =>
    Math.ceil(filtered.value.length / perPage.value)
);
function prevPage() {
    if (currentPage.value > 1) currentPage.value--;
}
function nextPage() {
    if (currentPage.value < totalPages.value) currentPage.value++;
}
</script>

<template>
    <div class="bg-gray-100 mb-24">
        <name name="testimonials" />

        <div class="m-4 mt-12 rounded">
            <div class="flex justify-between bg-white border-b-2 p-4 rounded-t">
                <h1 class="font-bold text-gray-500 text-lg">
                    Testimonial List
                </h1>
                <router-link
                    to="/testimonial"
                    class="bg-sky-700 text-white px-4 py-2 rounded hover:bg-sky-800"
                    >Add Testimonial</router-link
                >
            </div>

            <div class="bg-white p-4 shadow-md rounded-b">
                <!-- Bulk + Search -->
                <div class="flex justify-between items-center mb-4">
                    <div v-if="contTestimonials">
                        <span
                            class="bg-gray-200 text-blue-500 px-2 py-1 rounded-full font-bold"
                            >{{ contTestimonials }}</span
                        >
                        selected
                        <button
                            @click="hideSelected"
                            class="ml-2 bg-gray-200 text-red-500 p-2 rounded-full hover:bg-gray-300"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div class="relative">
                        <i
                            class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"
                        ></i>
                        <input
                            v-model="keywords"
                            type="text"
                            class="pl-10 pr-4 py-2 border rounded w-80 focus:ring-sky-500 focus:border-sky-500"
                            placeholder="Search"
                        />
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-gray-600">
                        <thead
                            class="bg-gray-50 uppercase text-xs text-gray-700"
                        >
                            <tr>
                                <th class="px-4 py-2">Mark</th>
                                <th class="px-4 py-2">Photo</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Description</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="t in paginated"
                                :key="t.id"
                                class="border-b hover:bg-gray-50"
                            >
                                <td
                                    class="px-4 py-2 cursor-pointer"
                                    @click="countSelect(t.id)"
                                >
                                    <div
                                        class="w-5 h-5 border rounded flex items-center justify-center"
                                    >
                                        <i
                                            v-if="
                                                removedTestimonialsId.includes(
                                                    t.id
                                                )
                                            "
                                            class="fas fa-check text-green-600"
                                        ></i>
                                    </div>
                                </td>
                                <td class="px-4 py-2">
                                    <img
                                        :src="t.image"
                                        class="w-16 h-10 object-cover rounded"
                                    />
                                </td>
                                <td class="px-4 py-2">{{ t.Name }}</td>
                                <td class="px-4 py-2">{{ t.discribution }}</td>
                                <td class="px-4 py-2 space-x-2">
                                    <button
                                        @click="openEdit(t)"
                                        class="text-white bg-blue-500 px-3 py-1 rounded hover:bg-blue-600"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button
                                        @click="deleteTestimonial(t.id)"
                                        class="text-white bg-red-500 px-3 py-1 rounded hover:bg-red-600"
                                    >
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4 flex justify-center space-x-2">
                    <button
                        @click="prevPage"
                        :disabled="currentPage === 1"
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
                    >
                        Back
                    </button>
                    <span class="px-4 py-2 bg-gray-200 rounded">
                        Page {{ currentPage }} of {{ totalPages }}
                    </span>
                    <button
                        @click="nextPage"
                        :disabled="currentPage === totalPages"
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div
            v-if="showModal"
            class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center px-4 py-6 overflow-auto ml-5"
        >
            <div
                class="bg-white rounded-2xl w-full max-w-2xl h-full md:h-auto p-6 shadow-xl relative overflow-y-auto"
            >
                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-4">
                    <h2
                        class="text-2xl font-semibold text-gray-800 flex items-center"
                    >
                        <i class="fas fa-edit mr-2 text-blue-600"></i> Edit
                        Testimonial
                    </h2>
                    <button
                        @click="showModal = false"
                        class="text-gray-400 hover:text-gray-600 text-2xl leading-none"
                        title="Close"
                    >
                        &times;
                    </button>
                </div>

                <!-- Name Field -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Name</label
                    >
                    <input
                        v-model="selected.Name"
                        type="text"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                <!-- Description Field -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Description</label
                    >
                    <textarea
                        v-model="selected.discribution"
                        rows="4"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    ></textarea>
                </div>

                <!-- Image Upload -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Image</label
                    >
                    <input
                        type="file"
                        @change="onImageChange"
                        class="w-full text-sm text-gray-500"
                    />
                </div>

                <!-- Image Preview (Smaller Size) -->
                <div v-if="selected.preview || selected.image" class="mb-4">
                    <img
                        :src="selected.preview || selected.image"
                        class="w-32 h-32 object-cover rounded-lg border border-gray-200"
                        alt="Preview"
                    />
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 pt-2">
                    <button
                        @click="showModal = false"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300"
                    >
                        Cancel
                    </button>
                    <button
                        @click="saveEdit"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700"
                    >
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
