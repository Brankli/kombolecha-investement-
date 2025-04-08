<script setup>
const emit = defineEmits(['someEvent'])
const handelevent = (event)=>{
    emit('someEvent');
}
</script>

<template>
    <div @click.prevent="handelevent"
        class="absolute dropdowns bg-gray-700 border-2 border-gray-200 rounded shadow-sm">
        <div class=" flex flex-col text-md p-4 text-briteblue">
            <div class="border-b-2 lg:border-b-0 p-2 border-yellow-600">
                <router-link class="px-4 hover:border-b-4  border-darkred" to="/expansion">
                    <span>{{ $t('lang.expInvestment') }}</span>
                </router-link>
            </div>
            <div class="border-b-2 lg:border-b-0 p-2 border-yellow-600">
                <router-link class="px-4 hover:border-b-4  border-darkred" to="/development">
                    <span>{{ $t('lang.industrydev') }}</span>
                </router-link>
            </div>
            <div class="border-b-2 lg:border-b-0 p-2 border-yellow-600">
                <router-link class="px-4 hover:border-b-4   border-darkred" to="/minirals">
                    <span>{{ $t('lang.mining opma') }}</span>
                </router-link>
            </div>
        </div>
    </div>
</template>
<style>
.dropdowns{
    z-index: 10;
}
</style>

