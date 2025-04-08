<script setup>
const props = defineProps({
    question: '',
});

</script>
<template>
    <div class="  w-full bg-gray-100 shadow-xl p-8 shadow-gray-200  mx-auto">
        <h1 class="text-xl font-bold pl-0 underline text-darkblue p-4">Question ?</h1>
        <p>{{ props.question }}</p>
    </div>
</template>