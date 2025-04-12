<script setup>
const emit = defineEmits('someEvent');
const props = defineProps({
    zoomImage:''
});
const zoomIn =()=>{
    emit('someEvent');
}
</script>
<template>
    <div @click.prevent="zoomIn" class="fixed w-full z-50 bg-black  justify-center top-0 h-screen">
        <img :src="props.zoomImage" class="2-50 mx-auto object-auto max-w-screen max-h-screen" alt="">
    </div>
</template>