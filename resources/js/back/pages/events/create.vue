<script setup>
import { useRouter } from "vue-router"; // Import useRouter for navigation
import name from "../../components/name.vue";
import axios from "axios";
import { onMounted, ref, nextTick } from "vue";
import { useLocalStorage } from "@vueuse/core";
import succs from "../conformation/succ.vue";
import errs from "../conformation/err.vue";
import Quill from "quill";
import "quill/dist/quill.snow.css";

// Initialize router
const router = useRouter(); // Use the router for navigation

const event = ref("");
const type = ref("event");
const imageUpload = ref(null);
const info = ref("");
const succ = ref("");
const err = ref("");
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
        event.value = quillEditor.root.innerHTML;
    });
};

onMounted(() => {
    nextTick(() => {
        initializeEditor();
    });
});

const selectImage = () => {
    const selectedImage = imageUpload.value?.files?.[0];
    if (!selectedImage) return;
    selectedimagedata.value = URL.createObjectURL(selectedImage);
};

const postevent = async () => {
    const formData = new FormData();
    formData.append("event", event.value);
    formData.append("type", type.value);
    formData.append("info", info.value);

    if (imageUpload.value?.files?.[0]) {
        formData.append("image", imageUpload.value.files[0]);
    }

    axios.defaults.headers.common["Authorization"] = token.value;
    try {
        const res = await axios.post("./api/event/store", formData);
        succ.value = res.data.message;
        router.push("/newspage"); // Navigate to the "newspage" route after success
    } catch (error) {
        err.value = error.response?.data || "An error occurred";
    }
};
</script>

<template>
    <div>
        <name name="create events and announcements" />
        <succs v-if="succ" :succ="succ" />
        <errs v-if="err" :err="err" />
        <div class="bg-gray-100 p-16">
            <div
                class="border-2 bg-white border-gray-300 shadow-lg max-w-4xl mx-auto rounded shadow-gray-100"
            >
                <div class="w-full bg-white rounded-lg md:mt-0 xl:p-0">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1
                            class="text-lg text-sky-700 leading-tight tracking-wide"
                        >
                            Build your portfolio with previous work
                        </h1>
                        <form class="mb-6">
                            <div class="mb-6">
                                <label
                                    class="block mb-2 text-sm font-medium text-gray-900"
                                >
                                    Upload image of your work
                                </label>
                                <input
                                    accept=".png,.jpg,.jpeg"
                                    type="file"
                                    ref="imageUpload"
                                    @change="selectImage"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300"
                                />
                            </div>

                            <img
                                v-if="selectedimagedata"
                                :src="selectedimagedata"
                                class="h-72 object-cover mb-4"
                                alt="Selected Image Preview"
                            />

                            <label
                                class="block mb-2 text-sm font-medium text-gray-900"
                            >
                                News content
                            </label>
                            <div
                                ref="editorContainer"
                                class="border border-gray-300 rounded-lg p-4 bg-gray-50 min-h-[200px]"
                            ></div>

                            <div class="mb-6 mt-4">
                                <label
                                    class="block mb-2 text-sm font-medium text-gray-900"
                                >
                                    Read More links
                                </label>
                                <textarea
                                    v-model="info"
                                    rows="4"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300"
                                    placeholder="# Include relevant links..."
                                ></textarea>
                            </div>

                            <div class="mb-6">
                                <label
                                    class="block mb-2 text-sm font-medium text-gray-900"
                                >
                                    Sector
                                </label>
                                <select
                                    v-model="type"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5"
                                >
                                    <option value="event">Event</option>
                                    <option value="announcement">
                                        Announcement
                                    </option>
                                </select>
                            </div>

                            <button
                                @click.prevent="postevent"
                                class="text-white bg-blue-700 hover:bg-blue-800 w-full font-medium rounded-lg text-sm px-5 py-2.5"
                            >
                                Create
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
