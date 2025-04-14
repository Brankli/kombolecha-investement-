<script setup>
import axios from "axios";
import { onMounted, ref, computed } from "vue";
import succs from "../conformation/succ.vue";
import errs from "../conformation/err.vue";
import name from "../../components/name.vue";
import { useLocalStorage } from "@vueuse/core";
import { useAlertsStore } from "../../../store/useAlertsStore";

const alertstore = useAlertsStore();
const token = useLocalStorage("token", "");
const staffs = ref([]);

const succ = ref("");
const err = ref("");
const perPage = ref(5);
const currentPage = ref(1);
const keywords = ref("");

function getallstaff() {
  
  axios
    .get(`/api/staff/getall`)
    .then((res) => {
      staffs.value = res.data;
    })
    .catch((err) => console.log(err));
}

function deleteStaff(id) {
  axios.defaults.headers.common["Authorization"] = token.value;
  axios
    .delete(`/api/staff/deletes/${id}`)
    .then(() => {
      succ.value = "Staff deleted successfully!";
      staffs.value = staffs.value.filter((staff) => staff.id !== id);
    })
    .catch((error) => {
      err.value = "Failed to delete staff.";
      console.error(error);
    });
}

onMounted(async () => {
  await getallstaff();
});

const searching = computed(() => {
  const keyword = keywords.value.toLocaleLowerCase();
  return staffs.value.filter((item) => item.name.toLowerCase().includes(keyword));
});

const paginatedData = computed(() => {
  const start = (currentPage.value - 1) * perPage.value;
  const end = start + perPage.value;
  return searching.value.slice(start, end);
});

const totalPages = computed(() => Math.ceil(searching.value.length / perPage.value));
const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};
</script>

<template>
  <div class="bg-gray-100 mb-24">
    <name name="staffs" />
    <succs v-if="succ" :succ="succ" />
    <errs v-if="err" :err="err" />
    <div class="m-4 mt-12 rounded">
      <div
        class="w-full bg-white border-b-2 rounded border-gray-200 flex flex-row justify-between"
      >
        <h1 class="font-bold text-gray-500 text-lg p-4">Staff List</h1>
        <router-link
          to="/newstaff"
          class="w-fit text-white bg-sky-700 hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 m-4 text-center"
          >Add Staff</router-link
        >
      </div>
      <!-- table start here -->
      <div class="flex bg-white flex-col items-center justify-center">
        <div class="w-full relative p-2 overflow-x-auto shadow-md sm:rounded-lg xs:p-5">
          <div
            class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4"
          >
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
              <div
                class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none"
              >
                <i class="fa-solid fa-magnifying-glass"></i>
              </div>
              <input
                v-model="keywords"
                type="text"
                id="table-search"
                class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-sky-500 focus:border-sky-500 outline-none"
                placeholder="Search for items"
              />
            </div>
          </div>
          <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">Name</th>
                <th scope="col" class="px-6 py-3">Position</th>
                <th scope="col" class="px-6 py-3">Phone</th>
                <th scope="col" class="px-6 py-3">Email</th>
                <th scope="col" class="px-6 py-3">Image</th>
                <th scope="col" class="px-6 py-3">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="staff in paginatedData"
                :key="staff.id"
                class="bg-white border-b hover:bg-gray-50"
              >
                <td class="px-6 py-4">{{ staff.name }}</td>
                <td class="px-6 py-4">{{ staff.position }}</td>
                <td class="px-6 py-4">{{ staff.phone }}</td>
                <td class="px-6 py-4">{{ staff.email }}</td>
                <td class="px-6 py-4">
                  <img
                    :src="staff.image"
                    class="w-16 h-10 object-cover"
                    alt="staff-image"
                  />
                </td>

                <td class="px-6 py-4">
                  <button
                    @click="deleteStaff(staff.id)"
                    class="text-red-600 hover:underline"
                  >
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <div v-if="perPage >= 5" class="w-full justify-center gap-2 flex flex-row pt-4">
            <div>
              <button
                class="shadow p-2 bg-gray-200 active:text-red-500 hover:bg-gray-300 text-briteblue text-lg font-bold rounded"
                @click="prevPage"
                :disabled="currentPage === 1"
              >
                Back
              </button>
            </div>
            <div>
              <button
                class="shadow p-2 bg-gray-200 text-briteblue hover:bg-gray-300 text-lg font-bold rounded"
              >
                Page {{ currentPage }}
              </button>
            </div>
            <div>
              <button
                class="shadow p-2 bg-gray-200 active:text-red-500 text-briteblue hover:bg-gray-300 text-lg font-bold rounded"
                @click="nextPage"
                :disabled="currentPage === totalPages"
              >
                Next
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
