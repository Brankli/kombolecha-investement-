<script setup>
import navigation from './navigation.vue';
import socialMedia from './socialMedia.vue';
import logo from "./logo.vue";
import { onMounted, ref } from 'vue';
import axios from 'axios';

onMounted(async()=>{
    await axios.post('./api/visiters').then(res=>{
        console.log(res);
    }).catch(err=>{
        console.log(err);
    })
})


const hiddenClass = ref('');



const hiddenLogo = () => {
    if (window.scrollY) {
        hiddenClass.value = "hidden";
    } else {
        hiddenClass.value = '';
    }
}

onMounted(() => {
    window.addEventListener("scroll", hiddenLogo);
});
</script>
 
<template>
    <div class="border-b z-50 bg-white w-full top-0  shadow-lg">
        <div>
            <socialMedia />
            <logo :class="hiddenClass" />
        </div>
        <navigation class="border-b-2  border-gray-200 shadow-md shadow-gray-600" />
    </div>
</template>


