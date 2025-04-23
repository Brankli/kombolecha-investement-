<script setup>
import axios from "axios";
import { onMounted, ref, computed } from "vue";
import name from "../../components/name.vue";
import { useLocalStorage } from "@vueuse/core";
import { useAlertsStore } from "../../../store/useAlertsStore";

const alertstore = useAlertsStore();
const token = useLocalStorage("token", "");
const sliders = ref([]);
const perPage = ref(5);
const currentPage = ref(1);
const showModal = ref(false);
const selectedSlider = ref(null);
const newImage = ref(null);
const previewImage = ref(null);

const handleImageChange = (e) => {
  const file = e.target.files[0];
  if (file) {
    newImage.value = file;
    previewImage.value = URL.createObjectURL(file);
  }
};

const fetchSliders = async () => {
  try {
    axios.defaults.headers.common["Authorization"] = token.value;
    const res = await axios.get("./api/getall/sliders");
    sliders.value = res.data.data;
  } catch (err) {
    console.error("Error fetching sliders:", err);
  }
};

onMounted(fetchSliders);

const totalPages = computed(() => Math.ceil(sliders.value.length / perPage.value));
const paginatedSliders = computed(() => {
  const start = (currentPage.value - 1) * perPage.value;
  return sliders.value.slice(start, start + perPage.value);
});

const prevPage = () => {
  if (currentPage.value > 1) currentPage.value--;
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++;
};

const openEditModal = (slider) => {
  selectedSlider.value = { ...slider };
  previewImage.value = null;
  showModal.value = true;
};

const closeEditModal = () => {
  showModal.value = false;
};

const saveChanges = async () => {
  axios.defaults.headers.common["Authorization"] = token.value;

  try {
    const formData = new FormData();
    formData.append("title", selectedSlider.value.title);
    formData.append("description", selectedSlider.value.description);
    formData.append("order", selectedSlider.value.order);
    if (newImage.value) {
      formData.append("image", newImage.value);
    }

    await axios.post(`./api/update/sliders/${selectedSlider.value.id}`, formData, {});

    alertstore.success("Slider updated successfully!");
    await fetchSliders();
    closeEditModal();
    newImage.value = null;
    previewImage.value = null;
  } catch (error) {
    alertstore.error("Failed to update slider.");
    console.error("Update error:", error);
  }
};
</script>
<template>
  <div class="container mx-auto p-4">
    <name title="All Sliders" />
    <div class="overflow-x-auto bg-white shadow-md rounded-lg p-4">
      <table class="min-w-full text-sm text-left text-gray-600">
        <thead class="bg-gray-100">
          <tr>
            <th class="py-2 px-4">Image</th>
            <th class="py-2 px-4">Title</th>
            <th class="py-2 px-4">Description</th>
            <th class="py-2 px-4">Order</th>
            <th class="py-2 px-4">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(slider, index) in paginatedSliders"
            :key="index"
            class="border-b hover:bg-gray-50"
          >
            <td class="py-2 px-4">
              <img
                :src="`/storage/${slider.image}`"
                alt="slider"
                class="w-20 h-12 object-cover rounded"
              />
            </td>
            <td class="py-2 px-4">{{ slider.title }}</td>
            <td class="py-2 px-4">{{ slider.description }}</td>
            <td class="py-2 px-4">{{ slider.order }}</td>
            <td class="py-2 px-4">
              <button
                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600"
                @click="openEditModal(slider)"
              >
                Edit
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="mt-4 flex justify-between items-center">
        <button
          class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded"
          :disabled="currentPage === 1"
          @click="prevPage"
        >
          Previous
        </button>
        <span class="text-sm">Page {{ currentPage }} of {{ totalPages }}</span>
        <button
          class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded"
          :disabled="currentPage === totalPages"
          @click="nextPage"
        >
          Next
        </button>
      </div>
    </div>

    <!-- Edit Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white rounded-lg p-6 w-full max-w-lg">
        <h2 class="text-xl font-bold mb-4">Edit Slider</h2>
        <label class="block text-sm font-medium">Title</label>
        <input
          type="text"
          v-model="selectedSlider.title"
          class="w-full p-2 border rounded mb-3"
        />
        <label class="block text-sm font-medium">Description</label>
        <textarea
          v-model="selectedSlider.description"
          class="w-full p-2 border rounded mb-3"
        ></textarea>
        <label class="block text-sm font-medium">Order</label>
        <input
          type="number"
          v-model="selectedSlider.order"
          class="w-full p-2 border rounded mb-3"
        />
        <label class="block text-sm font-medium">Image</label>
        <input
          type="file"
          @change="handleImageChange"
          class="w-full p-2 border rounded"
        />
        <div v-if="previewImage || selectedSlider.image" class="mt-4">
          <img
            :src="previewImage || `/storage/${selectedSlider.image}`"
            class="w-64 max-h-60 object-contain border rounded"
            alt="Preview"
          />
        </div>
        <div class="mt-6 flex justify-end gap-2">
          <button
            @click="closeEditModal"
            class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded"
          >
            Cancel
          </button>
          <button
            @click="saveChanges"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
          >
            Save
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
