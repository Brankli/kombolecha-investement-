<script setup>
import name from "../../components/name.vue";
import axios from "axios";
import { useLocalStorage } from "@vueuse/core";
import { ref } from "vue";
import { useAlertsStore } from "../../../store/useAlertsStore";

const alertstore = useAlertsStore();
const imageInput = ref(null);
const selectedImage = ref(null);
const token = useLocalStorage("token", "");

const pname = ref("");
const position = ref("");
const phone = ref("");
const email = ref("");

const selectImage = (event) => {
  selectedImage.value = event.target.files[0];
};

const addStaff = () => {
  const formData = new FormData();
  if (selectedImage.value) {
    formData.append("image", selectedImage.value);
  }
  formData.append("name", pname.value);
  formData.append("position", position.value);
  formData.append("phone_no", phone.value);
  formData.append("email", email.value);

  axios.defaults.headers.common["Authorization"] = token.value;

  axios
    .post(`./api/staff`, formData)

    .then((res) => {
      alertstore.showSuccessToast(res.data.message);
      pname.value = "";
      position.value = "";
      phone.value = "";
      email.value = "";
      selectedImage.value = null;
      if (imageInput.value) imageInput.value.value = null;
    })
    .catch((err) => {
      alertstore.showErrortost(err.response?.data?.error || "Submission failed");
    });
};
</script>
<template>
  <name name="Add New Staff" />
  <div class="bg-gray-100 p-16">
    <div class="border-2 bg-white border-gray-300 shadow-lg max-w-4xl mx-auto rounded">
      <div class="w-full bg-white rounded-lg md:mt-0 xl:p-0">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1 class="text-lg text-sky-700 font-semibold tracking-wide capitalize">
            Add Staff
          </h1>
          <form class="mb-6" @submit.prevent="addStaff">
            <div class="mb-6">
              <label
                for="name"
                class="block mb-2 text-sm font-medium text-gray-900 capitalize"
              >
                Name
              </label>
              <input
                v-model="pname"
                type="text"
                id="name"
                placeholder="Name of person"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500 outline-none"
                required
              />
            </div>

            <div class="mb-6">
              <label
                for="position"
                class="block mb-2 text-sm font-medium text-gray-900 capitalize"
              >
                Position
              </label>
              <input
                v-model="position"
                type="text"
                id="position"
                placeholder="Position of person"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500 outline-none"
                required
              />
            </div>

            <div class="mb-6">
              <label
                for="phone"
                class="block mb-2 text-sm font-medium text-gray-900 capitalize"
              >
                Phone
              </label>
              <input
                v-model="phone"
                type="text"
                id="phone"
                placeholder="Phone of person"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500 outline-none"
                required
              />
            </div>

            <div class="mb-6">
              <label
                for="email"
                class="block mb-2 text-sm font-medium text-gray-900 capitalize"
              >
                Email
              </label>
              <input
                v-model="email"
                type="email"
                id="email"
                placeholder="Email of person"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500 outline-none"
                required
              />
            </div>

            <div class="mb-6">
              <label
                for="file"
                class="block mb-2 text-sm font-medium text-gray-900 capitalize"
              >
                Upload Staff Logo
              </label>
              <input
                id="file"
                type="file"
                accept=".jpg,.jpeg,.png,.gif"
                @change="selectImage"
                ref="imageInput"
                class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
              />
            </div>
            <button
              type="submit"
              class="text-white bg-blue-700 hover:bg-blue-800 w-fit mx-auto focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 capitalize block"
            >
              Add Staff
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
