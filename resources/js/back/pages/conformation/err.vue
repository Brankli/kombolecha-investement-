<script setup>
import { ref } from 'vue';

const errClass = ref('');
const props = defineProps({
    notsucce: '',
});

const hideror = () => {
    errClass.value = 'hidden';
}
</script>
<template>
    <div :class="errClass"
        class="border-2  border-orange-600 flex flex-row gap-6 bg-orange-200  font-roboto rounded-lg p-4 absolute w-fit">
        <div>
            <img src="asset/conformation/fail.png" class="w-16 rounded-full " alt="">
        </div>
        <div class="">
            <h1 class="font-bold text-lg">somthing went wrong</h1>
            <p class="text-md">{{ props.notsucce }}</p>
        </div>
        <div class="align-middle my-auto ">
            <i @click.prevent="hideror"
                class="material-icons my-auto text-darkblue font-2xl hover:bg-white active:bg-rose-400 w-fit rounded-full p-1 font-bold">close</i>
        </div>
    </div>
</template>