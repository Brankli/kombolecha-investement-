<script setup>
const emit = defineEmits(["someEvent"]);
const handleEvent = () => {
    emit("someEvent");
};
</script>

<template>
    <div
        @click.prevent="handleEvent"
        class="absolute dropdowns right-0 mt-1 w-64 bg-gray-800 border border-gray-300 rounded-lg shadow-lg overflow-hidden"
    >
        <div
            class="flex flex-col divide-y divide-gray-600 text-base text-white"
        >
            <router-link
                to="/expansion"
                class="px-6 py-3 hover:bg-gray-700 hover:text-orange-400 transition-all duration-200"
            >
                {{ $t("lang.expInvestment") }}
            </router-link>

            <router-link
                to="/development"
                class="px-6 py-3 hover:bg-gray-700 hover:text-orange-400 transition-all duration-200"
            >
                {{ $t("lang.industrydev") }}
            </router-link>

            <router-link
                to="/minirals"
                class="px-6 py-3 hover:bg-gray-700 hover:text-orange-400 transition-all duration-200"
            >
                {{ $t("lang.mining opma") }}
            </router-link>
        </div>
    </div>
</template>

<style scoped>
.dropdowns {
    z-index: 50;
}
</style>
