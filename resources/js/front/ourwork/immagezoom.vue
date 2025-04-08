<script setup>
const emit = defineEmits('someEvent');
const props = defineProps({
    zoomimage:''
});
const zoomin =()=>{
    emit('someEvent');
}
</script>
<template>
    <div @click.prevent="zoomin" class="fixed w-full z-50 bg-black  justify-center top-0 h-screen">
        <img :src="props.zoomimage" class="2-50 mx-auto object-auto max-w-screen max-h-screen" alt="">
    </div>
</template>