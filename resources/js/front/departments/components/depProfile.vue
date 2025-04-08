<script setup>
const props = defineProps({
    name:'',
    position:'',
    email:'',
    mobile:'',
    profile:'',
});
</script>

<template>
    <div class="border-2 border-gray-200 shadow-xl rounded-2xl justify-center items-center">
        <div class="text-center mt-4">
            <img :src="props.profile"
                class="w-40 h-40 object-cover mx-auto rounded-full border-4 shadow-lg border-darkblue" alt="">
        </div>
        <div class="text-center bg-darkblue gap-y-4 p-8 mt-4 mb-0 text-white rounded">
            <p class="font-bold text-3xl pl-0 p-4 pb-3 tracking-widest capitalize  ">{{ props.name }}</p>
            <p class="font text-xl pb-2  tracking-widest  capitalize">{{ props.position }}</p>
            <p class="font text-sm p-2 pl-0 tracking-wider">{{ props.email }}</p>
            <p class="font text-sm p-2 pl-0  tracking-wider"> {{ props.mobile }}</p>
            <p class="font text-sm p-2 pl-0  tracking-wider">open from Monday-Friday,
                2:00-11:00</p>
            <router-link to="/contact"
                class="text-white mx-auto bg-blue-700 hover:bg-blue-800 w-fit focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5  dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 block">ask
                question</router-link>
        </div>
    </div>
</template>