<script setup>
import name from "../../components/name.vue";
import axios from "axios";
import { ref, onMounted, nextTick } from "vue";
import { useLocalStorage } from "@vueuse/core";
import { useRoute } from "vue-router";
import succs from "../conformation/succ.vue";
import errs from "../conformation/err.vue";
import Quill from "quill";
import "quill/dist/quill.snow.css";

const route = useRoute();
const id = ref(route.params.id);
const event = ref({ event: "", type: "", info: "" });
const imageUpload = ref(null);
const succ = ref("");
const err = ref("");
const token = useLocalStorage("token", "");
const selectedimagedata = ref("");

const editorContainer = ref(null);
let quillEditor = null;

onMounted(async () => {
  try {
    const res = await axios.get(`./api/event/edit/${id.value}`);
    event.value = res.data.event;
    await nextTick();
    initializeEditor();
  } catch (error) {
    console.error(error);
  }
});

const initializeEditor = () => {
  if (!editorContainer.value) return;

  quillEditor = new Quill(editorContainer.value, {
    theme: "snow",
    modules: {
      toolbar: [
        [{ header: [1, 2, 3, false] }],
        ["bold", "italic", "underline"],
        [{ list: "ordered" }, { list: "bullet" }],
        ["link", "image"],
        ["clean"],
      ],
    },
    placeholder: "Write event or announcement content here...",
  });

  if (event.value.event) {
    quillEditor.root.innerHTML = event.value.event;
  }

  quillEditor.on("text-change", () => {
    event.value.event = quillEditor.root.innerHTML;
  });
};

const formData = new FormData();

const selectImage = () => {
  const selectedImage = imageUpload.value?.files?.[0];
  selectedimagedata.value = URL.createObjectURL(selectedImage);
  if (selectedImage) {
    formData.set("image", selectedImage);
  }
};

const updateevent = async () => {
  formData.set("event", event.value.event);
  formData.set("type", event.value.type);
  formData.set("info", event.value.info);

  axios.defaults.headers.common["Authorization"] = token.value;
  try {
    const res = await axios.post(`./api/event/update/${id.value}`, formData);
    succ.value = res.data.message;
  } catch (error) {
    err.value = error.response?.data || "An error occurred";
  }
};
</script>

<template>
  <div>
    <div>
      <name name="Edit Events and Announcements" />
      <succs v-if="succ" :succ="succ" />
      <errs v-if="err" :err="err" />
      <div class="bg-gray-100 p-16"></div>
    </div>
    <div
      class="border-2 bg-white border-gray-300 shadow-lg max-w-4xl mx-auto rounded shadow-gray-100"
    >
      <div class="w-full bg-white rounded-lg md:mt-0 xl:p-0">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1 class="text-lg text-sky-700 leading-tight tracking-wide">
            fill events or announcements.
          </h1>

          <div class="mb-6">
            <label for="file" class="block mb-2 text-sm font-medium text-gray-900"
              >Upload Image</label
            >
            <input
              accept=".png,.jpg,.jpeg"
              type="file"
              ref="imageUpload"
              @change="selectImage"
              class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg outline-none focus:ring-blue-500 focus:border-blue-500"
            />
            <img
              v-if="selectedimagedata"
              :src="selectedimagedata"
              class="h-72 object-cover mt-4"
              alt="Preview"
            />
          </div>

          <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900"
              >Event Content</label
            >
            <div
              ref="editorContainer"
              class="border border-gray-300 rounded-lg p-4 bg-gray-50 min-h-[200px]"
            ></div>
          </div>

          <div class="mb-6">
            <label for="info" class="block mb-2 text-sm font-medium text-gray-900"
              >Read More Links</label
            >
            <textarea
              id="info"
              v-model="event.info"
              rows="4"
              class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg outline-none focus:ring-blue-500 focus:border-blue-500"
              placeholder="Include any relevant links to additional information or related articles"
            ></textarea>
          </div>

          <div class="mb-6">
            <label for="type" class="block mb-2 text-sm font-medium text-gray-900"
              >Sector</label
            >
            <select
              v-model="event.type"
              class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg outline-none focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="event">Event</option>
              <option value="announcment">Announcement</option>
            </select>
          </div>

          <button
            @click.prevent="updateevent"
            class="text-white bg-blue-700 hover:bg-blue-800 w-full focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
          >
            Update
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style></style>
