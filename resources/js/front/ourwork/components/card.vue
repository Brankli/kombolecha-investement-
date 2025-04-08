<script setup>

const props = defineProps({
    work:'',
});

</script>
<template>
    <div class="card hover:shadow-lg">
                <img :src="work.image" class="w-full h-32 sm:h-48 object-cover" alt="">
                <div class="m-4">
                    <span class="font-normal text-lg font-roboto  mt-12">{{ work.title }}</span> <br />
                </div>
            </div>
</template>