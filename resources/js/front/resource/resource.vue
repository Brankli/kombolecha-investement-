<script setup>
const props = defineProps({
    resource: "",
});

function downloadpdf(resource) {
    if (resource) {
        const pdfUrl = `/${resource}`;
        const link = document.createElement("a");
        link.href = pdfUrl;
        link.setAttribute("download", `${props.resource.title}.pdf`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    } else {
        console.error("No PDF available for download.");
    }
}
</script>

<template>
    <div class="bg-white cursor-pointer rounded-lg">
        <div
            class="flex gap-3 bg-orange-200 p-2.5 border rounded flex-wrap border-sky-600"
        >
            <i class="fas fa-download text-darkblue"></i>

            <p
                @click.prevent="downloadpdf(props.resource.resource)"
                class="hover:text-sky-800 bg-orange-200"
            >
                {{ props.resource.title }}
            </p>
        </div>
    </div>
</template>
