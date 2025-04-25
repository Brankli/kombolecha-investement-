<script setup>
import { ref, onMounted, nextTick } from "vue";
import { useLocalStorage } from "@vueuse/core";
import { useRoute, useRouter } from "vue-router";
import Quill from "quill";
import "quill/dist/quill.snow.css";
import axios from "axios";
import name from "../../components/name.vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const route = useRoute();
const router = useRouter();
const id = ref(route.params.id);
const title = ref("");
const content = ref("");
const info = ref("");
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
        placeholder: "Write your news content here...",
    });

    quillEditor.on("text-change", () => {
        content.value = quillEditor.root.innerHTML;
    });

    if (content.value) {
        quillEditor.root.innerHTML = content.value;
    }
};

onMounted(async () => {
    try {
        const res = await axios.get(`./api/news/edit/${id.value}`);
        const newsData = res.data.news;
        title.value = newsData.title;
        content.value = newsData.content;
        info.value = newsData.info;
        if (newsData.image) selectedimagedata.value = newsData.image;
        await nextTick();
        initializeEditor();
    } catch (error) {
        toast.error("Failed to load news item.", { autoClose: 2000 });
    }
});

const selectImage = () => {
    const selectedImage = imageUpload.value?.files?.[0];
    if (!selectedImage) return;
    selectedimagedata.value = URL.createObjectURL(selectedImage);
};

const updateNews = async () => {
    const formData = new FormData();
    formData.append("title", title.value);
    formData.append("content", content.value);
    formData.append("info", info.value);
    if (imageUpload.value?.files?.[0]) {
        formData.append("image", imageUpload.value.files[0]);
    }

    axios.defaults.headers.common["Authorization"] = token.value;

    try {
        const res = await axios.post(`./api/news/update/${id.value}`, formData);
        toast.success(res.data.message || "News updated successfully!", {
            autoClose: 2000,
        });
        router.push("/newspage");
    } catch (error) {
        toast.error(error.response?.data || "Update failed", {
            autoClose: 2000,
        });
    }
};

const deleteNews = async () => {
    axios.defaults.headers.common["Authorization"] = token.value;

    try {
        await axios.delete(`./api/news/destroy/${id.value}`);
        toast.success("News deleted successfully!", { autoClose: 2000 });
        router.push("/newspage");
    } catch (error) {
        toast.error(error.response?.data || "Failed to delete news", {
            autoClose: 2000,
        });
    }
};
</script>

<template>
    <div>
        <name name="Edit News" />

        <div class="p-4 bg-gray-50 min-h-screen mb-20">
            <div
                class="max-w-2xl mx-auto bg-white border border-gray-200 rounded-md shadow-sm p-4"
            >
                <h1 class="text-base font-semibold text-sky-700 mb-3">
                    Edit News
                </h1>

                <form @submit.prevent="updateNews" class="space-y-4 text-sm">
                    <!-- Title -->
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

                    <!-- Content -->
                    <div>
                        <label class="block mb-1 text-gray-700"
                            >News Content</label
                        >
                        <div
                            ref="editorContainer"
                            class="min-h-[120px] rounded-md border border-gray-300 p-2 bg-gray-50 text-sm"
                        ></div>
                    </div>

                    <!-- Image Upload -->
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

                    <!-- Actions -->
                    <div class="flex items-center justify-between mt-4">
                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white py-1.5 px-4 rounded-md text-sm"
                        >
                            <i class="fas fa-save mr-1"></i> Update
                        </button>

                        <button
                            type="button"
                            @click="deleteNews"
                            class="text-red-600 hover:text-red-700 text-sm flex items-center gap-1"
                        >
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
