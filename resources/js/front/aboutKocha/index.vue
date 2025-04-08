<script setup>
import geography from './geography.vue';
import wheatherVue from './wheather.vue';
import infrastructure from './infrastructure.vue';
import advantage from './advantage.vue';

</script>
<template>
    <div class="mt-8 rounded-tl-3xl w-full justify-center bg-darkblue  pb-16 ">
        <div class="bg-history rounded-tl-3xl h-fit  object-cover">
            <img src="asset/images/Invest-kombolcha.png" class="w-full rounded-tl-3xl " alt="">
        </div>
        <div class=" mt-0 gap-4 md:flex md:flex-row justify-center items-center">
            <geography class="sm:w-9/12" />
            <wheatherVue class="sm:w-9/12" />
        </div>

        <div class="gap-4 md:flex  md:flex-row justify-center items-center">
            <infrastructure class="sm:w-9/12" />
            <advantage class="sm:w-9/12 mt-6" />
        </div>
    </div>
</template>
