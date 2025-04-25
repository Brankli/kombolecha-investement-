<script setup>
import { ref, onMounted, nextTick } from "vue";
import { useLocalStorage } from "@vueuse/core";
import { useRouter, useRoute } from "vue-router";
import Quill from "quill";
import "quill/dist/quill.snow.css";
import name from "../../components/name.vue";
import axios from "axios";

const router = useRouter();
const route = useRoute();

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

const newsId = route.params.id; // for editing

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

    // Update content on change
    quillEditor.on("text-change", () => {
        content.value = quillEditor.root.innerHTML;
    });

    // Set initial content if editing
    if (content.value) {
        quillEditor.root.innerHTML = content.value;
    }
};

// Fetch existing news data if editing
const fetchNews = async () => {
    if (!newsId) return;
    try {
        const res = await axios.get(`/api/news/show/${newsId}`, {
            headers: { Authorization: token.value },
        });
        const news = res.data.news;
        title.value = news.title;
        content.value = news.content;
        info.value = news.info;

        await nextTick(); // Wait DOM
        if (quillEditor) {
            quillEditor.root.innerHTML = content.value;
        }
    } catch (error) {
        err.value = "Failed to load news data";
    }
};

onMounted(async () => {
    await nextTick(); // Ensure DOM
    initializeEditor();
    await fetchNews();
});

const selectImage = () => {
    const selectedImage = imageUpload.value?.files?.[0];
    if (!selectedImage) return;
    selectedimagedata.value = URL.createObjectURL(selectedImage);
};

const post = async () => {
    const formData = new FormData();
    formData.append("title", title.value);
    formData.append("content", content.value);
    formData.append("info", info.value);

    if (imageUpload.value?.files?.[0]) {
        formData.append("image", imageUpload.value.files[0]);
    }

    axios.defaults.headers.common["Authorization"] = token.value;
    try {
        let res;
        if (newsId) {
            res = await axios.post(`/api/news/update/${newsId}`, formData);
        } else {
            res = await axios.post("/api/news/store", formData);
        }

        succ.value = res.data.message;
        router.push("/newspage");
    } catch (error) {
        err.value = error.response?.data || "An error occurred";
    }
};
</script>

<template>
    <div>
        <name :name="newsId ? 'Edit News' : 'Post News'" />

        <div class="p-4 bg-gray-50 min-h-screen mb-20">
            <div
                class="max-w-2xl mx-auto bg-white border border-gray-200 rounded-md shadow-sm p-4"
            >
                <h1 class="text-base font-semibold text-sky-700 mb-3">
                    {{ newsId ? "Edit News" : "Post News" }}
                </h1>

                <form @submit.prevent="post" class="space-y-4 text-sm">
                    <!-- News Title -->
                    <div>
                        <label for="title" class="block mb-1 text-gray-700"
                            >News Title</label
                        >
                        <textarea
                            id="title"
                            v-model="title"
                            rows="2"
                            placeholder="Enter news title"
                            class="w-full border border-gray-300 rounded-md p-1.5 bg-gray-50 focus:ring-1 focus:ring-blue-500 outline-none"
                        ></textarea>
                    </div>

                    <!-- News Content Editor -->
                    <div>
                        <label class="block mb-1 text-gray-700"
                            >News Content</label
                        >
                        <div
                            ref="editorContainer"
                            class="min-h-[120px] rounded-md border border-gray-300 p-2 bg-gray-50 text-sm"
                        ></div>
                    </div>

                    <!-- Upload Image -->
                    <div>
                        <label for="file" class="block mb-1 text-gray-700"
                            >Upload Image</label
                        >
                        <input
                            accept=".png,.jpg,.jpeg"
                            type="file"
                            ref="imageUpload"
                            @change="selectImage"
                            class="w-full border border-gray-300 rounded-md p-1.5 bg-gray-50 text-xs"
                        />
                        <img
                            v-if="selectedimagedata"
                            :src="selectedimagedata"
                            alt="Preview"
                            class="mt-2 max-w-[200px] rounded-sm border border-gray-200"
                        />
                    </div>

                    <div>
                        <button
                            type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-1.5 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm"
                        >
                            {{ newsId ? "Update News" : "Post News" }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
