<script setup>
import { ref, onMounted, nextTick } from "vue";
import { useLocalStorage } from "@vueuse/core";
import Quill from "quill";
import "quill/dist/quill.snow.css";
import name from "../../components/name.vue";
import axios from "axios";


const title = ref("");
const content = ref("");
const info = ref("");
const imageUpload = ref(null);
const succ = ref("");
const err = ref("");
const token = useLocalStorage("token", "");
const selectedimagedata = ref("");
const editorContainer = ref(null);
let quillEditor = null; 

// Function to initialize Quill Editor
const initializeEditor = () => {
  if (!editorContainer.value) return;

  quillEditor = new Quill(editorContainer.value, {
    theme: "snow",
    modules: {
      toolbar: [
        [{ header: [1, 2, 3, 4, false] }],
        ["bold", "italic", "underline", "strike"],
        [{ script: "sub" }, { script: "super" }],
        [{ color: [] }, { background: [] }],
        [{ font: [] }],
        [{ list: "ordered" }, { list: "bullet" }],
        [{ align: [] }],
        ["link", "image", "blockquote", "code-block"],
        ["clean"],
      ],
    },
    placeholder: "Write your news content here...",
  });

  // Update content on text change
  quillEditor.on("text-change", () => {
    content.value = quillEditor.root.innerHTML;
  });
};

onMounted(async () => {
  await nextTick(); // Ensure DOM is ready
  initializeEditor();
});

// Handle image selection
const selectImage = () => {
  const selectedImage = imageUpload.value?.files?.[0];
  if (!selectedImage) return;

  selectedimagedata.value = URL.createObjectURL(selectedImage);
};

// Submit form data
const post = async () => {
  const formData = new FormData();
  formData.append("title", title.value);
  formData.append("content", content.value); // Contains HTML
  formData.append("info", info.value);

  if (imageUpload.value?.files?.[0]) {
    formData.append("image", imageUpload.value.files[0]);
  }

  axios.defaults.headers.common["Authorization"] = token.value;
  try {
    const res = await axios.post("./api/news/store", formData);
    succ.value = res.data.message;
    window.location.href = "/admin#/newspage";
  } catch (error) {
    err.value = error.response?.data || "An error occurred";
  }
};
</script>

<template>
  <name name="Post News" />
  <div class="bg-gray-100 p-16">
    <div class="border-2 bg-white border-gray-300 shadow-lg max-w-4xl mx-auto rounded shadow-gray-100">
      <div class="w-full bg-white rounded-lg md:mt-0 xl:p-0">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1 class="text-lg text-sky-700 leading-tight tracking-wide capitalize">
           
          </h1>
          <form class="mb-6">
            <!-- Title -->
            <div class="mb-6">
              <label for="title" class="block mb-2 text-sm font-medium text-gray-900 capitalize">
                News Article
              </label>
              <textarea
                id="title"
                v-model="title"
                rows="4"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
                placeholder="Enter a catchy and informative headline"
              ></textarea>
            </div>

            <!-- Quill Editor for News Content -->
            <div class="mb-6">
              <label class="block mb-2 text-sm font-medium text-gray-900 capitalize">
                News Content
              </label>
              <div ref="editorContainer" class=" border border-gray-300 rounded-lg p-4 bg-gray-50 min-h-[200px]" v-html="content"></div>
            </div>

            <!-- Image Upload -->
            <div class="mb-6">
              <label for="file" class="block mb-2 text-sm font-medium text-gray-900 capitalize">
                Upload Image for News
              </label>
              <input
                accept=".png,.jpg,.jpeg"
                type="file"
                ref="imageUpload"
                @change="selectImage"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
              />
            </div>

            <!-- Display selected image preview -->
            <img v-if="selectedimagedata" :src="selectedimagedata" alt="Preview" class="max-w-full h-auto mb-4" />

            <!-- Read More Links -->
            <div class="mb-6">
              <label for="info" class="block mb-2 text-sm font-medium text-gray-900 capitalize">
                Read More Links
              </label>
              <textarea
                id="info"
                v-model="info"
                rows="4"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
                placeholder="Include any relevant links to additional information or related articles"
              ></textarea>
            </div>

            <!-- Submit Button -->
            <button
              @click.prevent="post"
              class="text-white bg-blue-700 hover:bg-blue-800 w-full focus:ring-4 focus:ring-blue-300 font-medium rounded-lg capitalize text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 block"
            >
              Post News
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
