<script setup>
const props = defineProps({
    info:'',
});
</script>
<template>
    <div class="m-4 pt-16 text-sky-700 ">
        <h1 class="font-bold pb-8 text-darkred text-2xl">CONTACT</h1>
        <h1 class="font-bold pb-4 text-lg">For more information :-</h1>
        <div v-for="linksA in props.info" :key="linksA">
            <a :href="linksA" target="_blank">{{ linksA }}</a>
        </div>
    </div>
</template>
