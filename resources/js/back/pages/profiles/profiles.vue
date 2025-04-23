<script setup>
import name from "../../components/name.vue";
import axios from "axios";
import { useAlertsStore } from "../../../store/useAlertsStore";
import { useLocalStorage } from "@vueuse/core";
import { onMounted, ref } from "vue";

const alert = useAlertsStore();
const id = ref("");
const user = ref({});
const imageUpload = ref(null);
const token = useLocalStorage("token", "");
const selectedimagedata = ref("");
const fetchUserData = () => {
  axios
    .get(`./api/edit/user/1`)
    .then((res) => {
      user.value = res.data.user;
      id.value = res.data.user.id;
      selectedimagedata.value = res.data.user.image;
    })
    .catch((err) => console.error("Error fetching user:", err));
};

onMounted(() => {
  axios.defaults.headers.common["Authorization"] = token.value;
  fetchUserData();
});

const selectImage = (event) => {
  const file = event.target.files[0];
  if (file) {
    selectedimagedata.value = URL.createObjectURL(file);
  }
};

const updateProfile = async () => {
  try {
    const formData = new FormData();
    formData.append("name", user.value.name);
    formData.append("phone_no", user.value.phone_no);

    if (imageUpload.value.files[0]) {
      formData.append("image", imageUpload.value.files[0]);
    }
    const response = await axios.post(`./api/update/user/1`, formData);
    alert.showSuccessToast(response.data.message);
    await fetchUserData();
    imageUpload.value.value = "";
  } catch (error) {
    console.error("Update error:", error);
    const errorMessage = error.response?.data?.error || "Update failed";
    alert.showErrortost(errorMessage);
  }
};
</script>

<template>
  <name name="My Profile" />
  <div class="bg-gray-100 p-16">
    <div
      class="border-2 bg-white border-gray-300 shadow-lg max-w-4xl mx-auto rounded shadow-gray-100"
    >
      <div class="w-full bg-white rounded-lg md:mt-0 xl:p-0">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1 class="text-lg text-sky-700 leading-tight tracking-wide capitalize">
            Update your admin profile
          </h1>
          <form class="mb-6">
            <div class="mb-6">
              <label class="block mb-2 text-sm font-medium text-gray-900 capitalize">
                Upload profile picture
              </label>
              <input
                accept=".png,.jpg,.jpeg"
                type="file"
                ref="imageUpload"
                @change="selectImage"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
              />
            </div>

            <img
              v-if="selectedimagedata"
              :src="selectedimagedata"
              class="h-72 w-full object-cover mb-6 rounded-lg border"
              alt="Profile preview"
            />

            <div class="mb-6">
              <label class="block mb-2 text-sm font-medium text-gray-900"> Name </label>
              <input
                v-model="user.name"
                type="text"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none"
                placeholder="Enter name"
                required
              />
            </div>

            <div class="mb-6">
              <label class="block mb-2 text-sm font-medium text-gray-900 capitalize">
                Phone Number
              </label>
              <input
                v-model="user.phone_no"
                type="text"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none"
                placeholder="Enter phone number"
                required
              />
            </div>

            <button
              @click.prevent="updateProfile"
              class="text-white bg-blue-700 hover:bg-blue-800 w-full focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 transition-colors duration-200 capitalize"
            >
              Update Profile
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
