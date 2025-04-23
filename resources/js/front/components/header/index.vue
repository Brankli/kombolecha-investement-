<script setup>
import navigation from "./navigation.vue";
import socialMedia from "./socialMedia.vue";
import logo from "./logo.vue";
import { onMounted, onUnmounted, ref, nextTick } from "vue";

const isSticky = ref(false);
const navHeight = ref(0);
const navRef = ref(null);
const placeholderRef = ref(null);

const updateNavHeight = () => {
    nextTick(() => {
        if (navRef.value) {
            navHeight.value = navRef.value.offsetHeight;
        }
    });
};

const handleScroll = () => {
    if (!placeholderRef.value || !navRef.value) return;
    const rect = placeholderRef.value.getBoundingClientRect();
    isSticky.value = rect.top <= 0;
    if (isSticky.value) {
        updateNavHeight();
    }
};

onMounted(() => {
    updateNavHeight();
    window.addEventListener("scroll", handleScroll);
    window.addEventListener("resize", updateNavHeight);
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
    window.removeEventListener("resize", updateNavHeight);
});
</script>

<template>
    <div class="bg-white w-full">
        <div class="md:block left-0 right-0 top-0 z-50">
            <socialMedia />
            <logo />
        </div>

        <div ref="placeholderRef"></div>

        <div :style="{ height: isSticky ? navHeight + 'px' : '0px' }"></div>

        <div
            ref="navRef"
            :class="[
                'transition-all duration-300',
                isSticky
                    ? 'fixed top-0 left-0 w-full z-50 shadow-md bg-white'
                    : '',
            ]"
        >
            <navigation />
        </div>
    </div>
</template>
