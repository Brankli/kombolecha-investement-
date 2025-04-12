<script setup>
    const emit = defineEmits('someEvent');
    function filterWorks(keyword) {
        emit('someEvent', keyword)
    }
</script>
<template>
    <div class="flex flex-row  items-center justify-center gap-2 mb-8">
        <div>
            <button  @click.prevent="filterWorks('')"
                class="hover:border-green-300  border-b-2 border-gray-300 text-gray-900 text-sm  focus:border-blue-500  w-full p-2 outline-none">
                <span> All</span>
            </button>
        </div>
        <div>
            <button @click.prevent="filterWorks('In agro processing sectors')"
                class="hover:border-green-300  border-b-2 border-gray-300 text-gray-900 text-sm  focus:border-blue-500  w-full p-2 outline-none">
                <span>{{ $t('lang.Processing') }} </span>
            </button>
        </div>
        <div>
            <button @click.prevent="filterWorks('In chemical and construction sectors')"
                class="hover:border-green-300  border-b-2 border-gray-300 text-gray-900 text-sm  focus:border-blue-500  w-full p-2 outline-none ">
                <span>{{ $t('lang.ChemicalConstruction') }}</span>
            </button>
        </div>
        <div>
            <button @click.prevent="filterWorks('In the hotel and tourism sector')"
                class="hover:border-green-300  border-b-2 border-gray-300 text-gray-900 text-sm  focus:border-blue-500  w-full p-2 outline-none ">
                <span>{{ $t('lang.HotelTourism') }} </span>
            </button>
        </div>

        <div>
            <button @click.prevent="filterWorks('Construction sectors')"
                class="hover:border-green-300  border-b-2 border-gray-300 text-gray-900 text-sm  focus:border-blue-500  w-full p-2 outline-none ">
                <span>{{ $t('lang.Construction') }}</span>
            </button>
        </div>
        <div>
            <button @click.prevent="filterWorks('Urban agriculture sector')"
                class="hover:border-green-300  border-b-2 border-gray-300 text-gray-900 text-sm  focus:border-blue-500  w-full p-2 outline-none ">
                <span>{{ $t('lang.UrbanAgriculture') }} </span>
            </button>
        </div>
        <div>
            <button @click.prevent="filterWorks('Social sectorr')"
                class="hover:border-green-300  border-b-2 border-gray-300 text-gray-900 text-sm  focus:border-blue-500  w-full p-2 outline-none ">
                <span>{{ $t('lang.Social') }}</span>
            </button>
        </div>
    </div>
</template>
