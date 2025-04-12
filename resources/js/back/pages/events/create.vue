<script setup>
import name from "../../components/name.vue"
import axios from "axios"
import { onMounted, ref } from "vue";
import { useLocalStorage } from "@vueuse/core";
import succs from "../conformation/succ.vue";
import errs from "../conformation/err.vue";
import Quill from "quill";
import "quill/dist/quill.snow.css";

const event = ref('');
const type = ref('');
const imageUpload = ref(null);
const info = ref('');
const succ = ref('');
const err = ref('');
const token = useLocalStorage('token', '');
const selectedimagedata = ref('');

const editorContainer = ref(null);
let quillEditor = null;

const initializeEditor = () => {
    if (!editorContainer.value) return;
     quillEditor = new Quill(editorContainer.value, {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ header: [1, 2, 3, 4, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ script: 'sub' }, { script: 'super' }],
                [{ color: [] }, { background: [] }],
                [{ font: [] }],
                [{ list: 'ordered' }, { list: 'bullet' }],
                [{ align: [] }],
                ['link', 'image', 'blockquote', 'code-block'],
                ['clean'],
            ],
        },
    });
    quillEditor.on('text-change', () => {
        event.value = quillEditor.root.innerHTML;
    });
};
onMounted(async () => {
    initializeEditor();
});
const formData = new FormData();

const selectImage = () => {
    const selectedImage = imageUpload.value.files[0];
    selectedimagedata.value = URL.createObjectURL(selectedImage);
    if (selectedImage) {
        formData.append('image', selectedImage);
    }
}

const postevent = () => {
    formData.append('event', event.value);
    formData.append('type', type.value);
    formData.append('info', info.value);
    axios.defaults.headers.common['Authorization'] = token.value;
    axios.post('./api/event/store', formData).then(res => {
        succ.value = res.data.message;
        window.location.href = "/admin#/newspage"
    }).catch(res => {
        err.value = res.data;
    })
}
</script>
<template>
    <name name="create events and announcements" />
    <succs v-if="succ" :succ="succ" />
    <errs v-if="err" :err="err" />
    <div class="bg-gray-100 p-16">
        <div class="border-2  bg-white border-gray-300 shadow-lg max-w-4xl mx-auto rounded shadow-gray-100">
            <div class="w-full  bg-white rounded-lg   md:mt-0 xl:p-0 ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-lg  text-sky-700 leading-tight tracking-wide">build your portifolio with privious work
                    </h1>
                    <form class="mb-6">
                        <div class="mb-6">
                            <label for="file" class="block mb-2 text-sm font-medium text-gray-900">Upload image of your
                                work</label>
                            <input accept=".png,.jpg,.jpeg" type="file" rows="4" ref="imageUpload" @change="selectImage"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                placeholder="Your question..." />
                        </div>
                        <img v-if="selectedimagedata" :src="selectedimagedata" class="h-72 object-cover" alt="">

                        
                            <label for="body" class="block mb-2 text-sm font-medium text-gray-900">News content</label>
                            <div ref="editorContainer" class="border border-gray-300 rounded-lg p-4 bg-gray-50 min-h-[200px]"
                                v-html="event"></div>
                     
                        <div class="mb-6">
                            <label for="info" class="block mb-2 text-sm font-medium text-gray-900">Read More links</label>
                            <textarea id="info" v-model="info" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                placeholder="# Please include any relevant links to additional information or related articles.."></textarea>
                        </div>
                        <div class="mb-6">
                            <label for="sector" class="block mb-2 text-sm font-medium text-gray-900 ">sector</label>
                            <select v-model="type" name="time" id="time"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none">
                                <option selected value="event">Event</option>
                                <option value="announcment">Announcemnt</option>
                            </select>
                        </div>
                        <button @click.prevent="postevent"
                            class="text-white bg-blue-700 hover:bg-blue-800 w-full focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 block">create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

