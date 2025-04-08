<script setup>
const emit = defineEmits('someEvent');
function filterwork(keyword){
    emit('someEvent', keyword)
}
</script>
<template>
    <div class="hidden sm:flex">
        <nav>
            <ul class="text-xl flex md:flex sm:block  gap-2 lg:gap-8  mt-6 text-darkred font-bold ">
                <div class="sm:flex gap-2 lg:gap-8 ">
                    <li>
                        <button @click.prevent="filterwork('In agro processing sectors')"
                            class="bg-gray-50 hover:bg-green-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  w-full p-2 outline-none">
                            <span>{{ $t('lang.Processing') }} </span>
                        </button>
                    </li>
                    <li>
                        <button @click.prevent="filterwork('In chemical and construction sectors')"
                            class="bg-gray-50 hover:bg-green-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  w-full p-2 outline-none ">
                            <span>{{ $t('lang.ChemicalConstruction') }}</span>
                        </button>
                    </li>
                    <li>
                        <button @click.prevent="filterwork('In the hotel and tourism sector')"
                            class="bg-gray-50 hover:bg-green-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  w-full p-2 outline-none ">
                            <span>{{ $t('lang.HotelTourism') }} </span>
                        </button>
                    </li>
                </div>
                <div class="sm:flex gap-2 lg:gap-8 sm:mt-4 md:mt-0">
                    <li>
                        <button @click.prevent="filterwork('Construction sectors')"
                            class="bg-gray-50 hover:bg-green-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  w-full p-2 outline-none ">
                            <span>{{ $t('lang.Construction') }}</span>
                        </button>
                    </li>
                    <li>
                        <button @click.prevent="filterwork('Urban agriculture sector')"
                            class="bg-gray-50 hover:bg-green-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  w-full p-2 outline-none ">
                            <span>{{ $t('lang.UrbanAgriculture') }} </span>
                        </button>
                    </li>
                    <li>
                        <button @click.prevent="filterwork('Social sectorr')"
                            class="bg-gray-50 hover:bg-green-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  w-full p-2 outline-none ">
                            <span>{{ $t('lang.Social') }}</span>
                        </button>
                    </li>
                </div>
            </ul>
        </nav>
    </div>
</template>
