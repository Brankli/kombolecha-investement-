<script setup>
import { ref } from 'vue';

const succClass = ref('');
const props = defineProps({
    succ: '',
});

const hidesuccess = () => {
    succClass.value = 'hidden';
}

</script>
<template>
    <div :class="succClass"
        class="border-2  border-green-600 flex flex-row gap-6 bg-green-200  font-roboto rounded-lg p-4 absolute w-fit">
        <div>
            <img src="asset/conformation/suc.png" class="w-16 rounded-full " alt="">
        </div>
        <div class="">
            <h1 class="font-bold text-lg">congrajulation</h1>
            <p class="text-md">{{ props.succ }}</p>
        </div>
        <div class="align-middle my-auto ">
            <i @click.prevent="hidesuccess"
                class="material-icons my-auto text-darkblue font-2xl hover:bg-white active:bg-rose-400 w-fit rounded-full p-1 font-bold">close</i>
        </div>
    </div>
</template>