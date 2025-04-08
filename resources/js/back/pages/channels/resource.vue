<script setup>
import axios from 'axios';
import { defineProps } from 'vue';

const props = defineProps({
    resource: '',
    title: ''
});

function downloadpdf(resource) {
    if (resource) {
        const pdfUrl = `/${resource}`;
        const link = document.createElement('a');
        link.href = pdfUrl;
        link.setAttribute('download', `${props.title}.pdf`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    } else {
        console.error('No PDF available for download.');
    }
}
</script>

<template>
    <div class="w-fit flex flex-col md:mt-0 hover:ml-4 m-3 xl:p-0">
        <div class="flex gap-3 rounded shadow-2xl">
            <i class="material-icons text-orange-300">download</i>
            <button @click.prevent="downloadpdf(props.resource)" class="hover:text-sky-800">{{ props.title }}</button>
        </div>
    </div>
</template>
