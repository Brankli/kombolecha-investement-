<script setup>
import name from "../../components/name.vue";
import axios from "axios";
import { ref, onMounted, watch } from "vue";
import { useLocalStorage } from "@vueuse/core";
import { useAlertsStore } from "../../../store/useAlertsStore";
import Quill from "quill";
import "quill/dist/quill.snow.css";

const alertstore = useAlertsStore();
const message = ref("");
const Name = ref("");
const imageUpload = ref(null);
const token = useLocalStorage("token", "");
const selectedimagedata = ref("");
const editorContainer = ref(null);
let quillEditor = null;

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
    placeholder: "Write your description",
  });

  quillEditor.on("text-change", () => {
    message.value = quillEditor.root.innerHTML;
  });

  quillEditor.root.innerHTML = message.value;
};

const formData = new FormData();

const selectImage = () => {
  const selectedImage = imageUpload.value.files[0];
  console.log(selectedImage);
  selectedimagedata.value = URL.createObjectURL(selectedImage);
  if (selectedImage) {
    formData.append("image", selectedImage);
  }
};

const post = () => {
  formData.append("discribution", message.value);
  formData.append("Name", Name.value);
  axios.defaults.headers.common["Authorization"] = token.value;
  axios
    .post("./api/store/testimonial", formData)
    .then((res) => {
      alertstore.showSuccessToast(res.data.message);
      setTimeout(() => {
        message.value = "";
        Name.value = "";
        quillEditor.root.innerHTML = "";
      }, 2000);
    })
    .catch((error) => {
      alertstore.showErrortost(error.response.data.error);
    });
};

onMounted(() => {
  initializeEditor();
});

defineProps({
  modelValue: {
    type: String,
    default: "",
  },
});

const emit = defineEmits(["update:modelValue"]);

watch(
  () => message.value,
  (newValue) => {
    emit("update:modelValue", newValue);
  }
);
</script>

<template>
  <div>
    <name name="Add New Testimonial" />
    <div class="bg-gray-100 p-16">
      <div
        class="border-2 bg-white border-gray-300 shadow-lg max-w-4xl mx-auto rounded shadow-gray-100"
      >
        <div class="w-full bg-white rounded-lg md:mt-0 xl:p-0">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-lg text-sky-700 leading-tight tracking-wide capitalize">
              Add your client testimonials with not more than 30 words
            </h1>
            <form class="mb-6">
              <div class="mb-6">
                <label
                  for="body"
                  class="block mb-2 text-sm font-medium text-gray-900 capitalize"
                >
                  Name</label
                >
                <input
                  id="body"
                  v-model="Name"
                  rows="4"
                  class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
                  placeholder="Please enter your name"
                />
              </div>
              <!-- Removed v-html -->
              <div
                ref="editorContainer"
                class="border border-gray-300 rounded-lg p-4 bg-gray-50 min-h-[200px]"
              ></div>
              <div class="mb-6">
                <label
                  for="file"
                  class="block mb-2 text-sm font-medium text-gray-900 capitalize"
                  >Client Photo</label
                >
                <input
                  accept=".png,.jpg,.jpeg"
                  type="file"
                  rows="4"
                  ref="imageUpload"
                  @change="selectImage"
                  class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
                  placeholder="Your question..."
                />
              </div>
              <img v-if="selectedimagedata" :src="selectedimagedata" alt="" />
              <button
                @click.prevent="post"
                class="text-white bg-blue-700 hover:bg-blue-800 w-fit mx-auto focus:ring-4 focus:ring-blue-300 font-medium rounded-lg capitalize text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 block"
              >
                Add testimonial
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
