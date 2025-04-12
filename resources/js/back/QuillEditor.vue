<script setup>
import { ref, onMounted, watch, defineProps } from 'vue';
import Quill from 'quill';
import 'quill/dist/quill.snow.css';

const props = defineProps({
    selectedCourse: {
        type: Object,
        required: true,
    }
});

const emit = defineEmits(['update-overview']);

const editorContainer = ref(null);
let quillEditor = null;

// Initialize Quill editor
const initializeEditor = () => {
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
        placeholder: 'Write your news content here...',
    });

    // Set initial content
    if (props.selectedCourse.overview) {
        quillEditor.root.innerHTML = props.selectedCourse.overview;
    }

    // Handle content changes
    quillEditor.on('text-change', () => {
        const htmlContent = quillEditor.root.innerHTML;
        emit('update-overview', htmlContent);
    });
};

watch(
    () => props.selectedCourse.overview,
    (newContent) => {
        if (quillEditor && newContent !== quillEditor.root.innerHTML) {
            quillEditor.root.innerHTML = newContent || '';
        }
    }
);

onMounted(() => {
    initializeEditor();
});
</script>

<template>
    <div class="w-full bg-gray-50 flex justify-center items-start">
        <div class="bg-white shadow-lg rounded-lg p-1 w-full">
            <div ref="editorContainer" class="border border-gray-300 rounded-lg p-4 bg-gray-50 min-h-[200px]"></div>
        </div>
    </div>
</template>

<style scoped>
/* Add any custom styles here */
.ql-container {
    font-family: 'Inter', sans-serif;
    font-size: 16px;
    line-height: 1.6;
    color: #333;
    min-height: 200px;
}
</style>