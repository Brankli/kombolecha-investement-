<script setup>
import axios from "axios";
import { onMounted, ref, computed, watch } from "vue";
import succs from "../conformation/succ.vue";
import errs from "../conformation/err.vue";
import name from "../../components/name.vue";
import { useLocalStorage } from "@vueuse/core";
import { useAlertsStore } from "../../../store/useAlertsStore";

const alertstore = useAlertsStore();
const token = useLocalStorage("token", "");
const users = ref([]);

const succ = ref("");
const err = ref("");
const perPage = ref(5);
const currentPage = ref(1);
const keywords = ref("");
const editingStaff = ref(null);

const editForm = ref({
  name: "",
  position: "",
  phone_no: "",
  email: "",
  image: "",
});

const imagePreview = ref(null);

function getallstaff() {
  axios.defaults.headers.common["Authorization"] = token.value;
  axios
    .get("/api/user/getall")
    .then((res) => {
      users.value = res.data;
    })
    .catch((err) => console.log(err));
}

function editStaff(staff) {
  editingStaff.value = staff;
  editForm.value = {
    name: staff.name,
    position: staff.position,
    phone_no: staff.phone_no,
    email: staff.email,
    image: "", // New upload, not existing image URL
  };
  imagePreview.value = staff.image;
}

function handleFileChange(e) {
  const file = e.target.files[0];
  if (file) {
    editForm.value.image = file;
    imagePreview.value = URL.createObjectURL(file);
  }
}

function saveEdit() {
  const formData = new FormData();
  formData.append("name", editForm.value.name);
  formData.append("position", editForm.value.position);
  formData.append("phone_no", editForm.value.phone_no);
  formData.append("email", editForm.value.email);
  if (editForm.value.image) {
    formData.append("image", editForm.value.image);
  }

  axios.defaults.headers.common["Authorization"] = token.value;
  axios
    .post(`/api/update/user/${editingStaff.value.id}`, formData)
    .then((res) => {
      succ.value = "Staff updated successfully!";
      setTimeout(() => (succ.value = ""), 3000);
      const index = users.value.findIndex((s) => s.id === editingStaff.value.id);
      if (index !== -1) {
        users.value[index] = res.data;
      }
      editingStaff.value = null;
    })
    .catch((error) => {
      err.value = "Failed to update staff.";
      setTimeout(() => (err.value = ""), 3000);
      console.error(error);
    });
}

onMounted(() => {
  getallstaff();
});

const searching = computed(() => {
  const keyword = keywords.value.toLowerCase();
  return users.value.filter((item) => item.name.toLowerCase().includes(keyword));
});

const paginatedData = computed(() => {
  const start = (currentPage.value - 1) * perPage.value;
  const end = start + perPage.value;
  return searching.value.slice(start, end);
});

const totalPages = computed(() => Math.ceil(searching.value.length / perPage.value));
const prevPage = () => {
  if (currentPage.value > 1) currentPage.value--;
};
const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++;
};
</script>

<template>
  <div class="bg-gray-100 mb-24">
    <name name="users" />
    <succs v-if="succ" :succ="succ" />
    <errs v-if="err" :err="err" />

    <div class="m-4 mt-12 rounded">
      <div
        class="w-full bg-white border-b-2 rounded border-gray-200 flex justify-between"
      >
        <h1 class="font-bold text-gray-500 text-lg p-4">Staff List</h1>
        <router-link
          to="/newstaff"
          class="w-fit text-white bg-sky-700 hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 m-4"
        >
          Add Staff
        </router-link>
      </div>

      <!-- table -->
      <div class="flex bg-white flex-col items-center justify-center">
        <div class="w-full relative p-2 overflow-x-auto shadow-md sm:rounded-lg xs:p-5">
          <!-- Search -->
          <div class="flex flex-col sm:flex-row justify-between pb-4">
            <div class="relative mb-2 sm:mb-0">
              <div
                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
              >
                <i class="fa-solid fa-magnifying-glass"></i>
              </div>
              <input
                v-model="keywords"
                type="text"
                id="table-search"
                class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-sky-500 focus:border-sky-500"
                placeholder="Search for name"
              />
            </div>
          </div>

          <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
              <tr>
                <th class="px-6 py-3">No</th>
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Position</th>
                <th class="px-6 py-3">Phone</th>
                <th class="px-6 py-3">Email</th>
                <th class="px-6 py-3">Image</th>
                <th class="px-6 py-3">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(staff, index) in paginatedData"
                :key="staff.id"
                class="bg-white border-b hover:bg-gray-50"
              >
                <td class="px-6 py-4">
                  {{ index + 1 + (currentPage - 1) * perPage }}
                </td>
                <td class="px-6 py-4">{{ staff.name }}</td>
                <td class="px-6 py-4">{{ staff.position }}</td>
                <td class="px-6 py-4">{{ staff.phone_no }}</td>
                <td class="px-6 py-4">{{ staff.email }}</td>
                <td class="px-6 py-4">
                  <img :src="staff.image" class="w-16 h-10 object-cover rounded" />
                </td>
                <td class="px-6 py-4">
                  <button @click="editStaff(staff)" class="text-blue-600 hover:underline">
                    Edit
                  </button>
                </td>
              </tr>
            </tbody>
          </table>

          <!-- Pagination -->
          <div v-if="perPage >= 5" class="w-full flex justify-center gap-2 pt-4">
            <button
              @click="prevPage"
              :disabled="currentPage === 1"
              class="shadow px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded"
            >
              Back
            </button>
            <span class="px-4 py-2 text-sm">Page {{ currentPage }}</span>
            <button
              @click="nextPage"
              :disabled="currentPage === totalPages"
              class="shadow px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded"
            >
              Next
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Modal -->
    <div
      v-if="editingStaff"
      class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white p-6 rounded shadow-lg w-96">
        <h2 class="text-lg font-bold mb-4">Edit Staff</h2>
        <form @submit.prevent="saveEdit">
          <div class="mb-4">
            <label class="block text-sm font-medium">Name</label>
            <input
              v-model="editForm.name"
              type="text"
              class="w-full border rounded p-2"
            />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium">Position</label>
            <input
              v-model="editForm.position"
              type="text"
              class="w-full border rounded p-2"
            />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium">Phone</label>
            <input
              v-model="editForm.phone_no"
              type="text"
              class="w-full border rounded p-2"
            />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium">Email</label>
            <input
              v-model="editForm.email"
              type="email"
              class="w-full border rounded p-2"
            />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium">Image</label>
            <input type="file" @change="handleFileChange" class="w-full" />
            <img
              v-if="imagePreview"
              :src="imagePreview"
              class="mt-2 w-24 h-16 object-cover border rounded"
              alt="Preview"
            />
          </div>
          <div class="flex justify-end">
            <button
              type="button"
              @click="editingStaff = null"
              class="mr-2 px-4 py-2 bg-gray-300 rounded"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="px-4 py-2 bg-blue-600 text-white rounded"
              :disabled="!editForm.name || !editForm.email"
            >
              Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
