<script setup>
import headers from "./components/header/index.vue"
import footers from "./components/footer.vue";
import {ref, onMounted} from "vue";

const headerClass = ref('');
const topclass = ref('');



const bodyScrolled = () => {
    if (window.scrollY > 0) {
        headerClass.value = "fixed top-0 left-0 w-full bg-white shadow-md z-50";
        topclass.value = "mt-48"
    } else {
        headerClass.value = '';
        topclass.value = ""
    }
}

onMounted(() => {
    window.addEventListener("scroll", bodyScrolled);
});

</script>
<template>
    <div class="">
        <headers :class="headerClass" />
        <div :class="topclass ">
            <router-view />
            <footers />
        </div>
    </div>
</template>