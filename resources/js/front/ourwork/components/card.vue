<script setup>

const props = defineProps({
    work:'',
});

</script>
<template>
    <div  class=""> 
         <div class="relative">
            <img
                :src="work.image"
                :alt="work.image"
                class="w-full h-64 object-cover rounded-t transition-transform duration-500 group-hover:scale-105"
            />
            <!-- Overlay that appears on hover -->
            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-60 opacity-0 group-hover:opacity-100 transition-all duration-500" >
                <span class="text-white text-lg font-semibold capitalize tracking-wide" > {{ work.title }} </span>
            </div>
        </div> 
    </div>
</template>