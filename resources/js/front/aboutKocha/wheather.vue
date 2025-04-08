<template>
    <div
        class="w-fit  max-w-5xl md:h-full bg-darkblue text-white p-4  text-xl   border-4 border-blue-500 shadow-2xl shadow-blue-900 rounded-md ">
        <h1 class="text-4xl capitalize text-yellow-500 font-bold border-b-2 border-yellow-500 w-fit  tracking-normal"> {{ $t('lang.naturalresources') }}</h1>
        <div class="p-2 flex flex-row gap-3 w-full md:mt-0 mt-3 m-3 xl:p-0">
            <i class="material-icons text-blue-500 shadow-2xl  shadow-blue-900 ">done</i>
            <p class="text-white"> {{ $t('lang.animalresources') }} </p>
        </div>
        <div class="p-2 flex flex-row gap-3 w-full md:mt-0 mt-3 m-3 xl:p-0">

            <i class="material-icons text-blue-500 shadow-2xl  shadow-blue-900 ">done</i>
            <p>{{ $t('lang.factoryinput') }}</p>
        </div>
        <div class="p-2 flex flex-row gap-3 w-full md:mt-0 mt-3 m-3 xl:p-0">
            <i class="material-icons   text-blue-500 shadow-2xl  shadow-blue-900 ">done</i>
            <p>{{ $t('lang.climate') }}</p>
        </div>
        <div class="p-2 flex flex-row gap-3 w-full md:mt-0 mt-3 m-3 xl:p-0">
            <i class="material-icons font-bold text-blue-500 shadow-2xl  shadow-blue-900 ">done</i>
            <p>{{ $t('lang.groundwaterresources') }}</p>
        </div>
        <div class="p-2 flex flex-row gap-3 w-full md:mt-0 mt-3 m-3 xl:p-0">
            <i class="material-icons font-bold text-blue-500 shadow-2xl  shadow-blue-900 ">done</i>
            <p>{{ $t('lang.minerals') }}</p>
        </div>
        <div class="p-2 flex flex-row gap-3 w-full md:mt-0 mt-3 m-3 xl:p-0">
            <i class="material-icons font-bold text-blue-500 shadow-2xl  shadow-blue-900 ">done</i>
            <p>{{ $t('lang.investment') }}</p>
        </div>
    </div>
</template>
<style scoped>p {
    padding: 2px;
}</style>