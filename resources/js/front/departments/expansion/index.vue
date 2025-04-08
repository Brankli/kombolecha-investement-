<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import depProfile from '../components/depProfile.vue';

const departments = ref([]);
const services = ref([]);

onMounted(async () => {
    await axios.get('./api/getall/department').then(res => {
        departments.value = res.data.DepartmentContent;
    }).catch(err => console.log(err));
    await axios.get('./api/service/getall').then(res => {
        services.value = res.data.services;
    }).catch(err => console.log(err));

})
</script>

<template>
    <div v-for="departmenthead in departments.data " :key="departmenthead.id" class="font-roboto">
        <div v-if="departmenthead.position === 'expansion director'">
            <div class="  w-screen h-64 bg-darkblue ">
                <div class="text-center  ">
                    <h1 class="text-4xl font-bold p-16 font-roboto rounded-lg text-white">Expansion Of Investment </h1>
                    <div
                        class="border-b-2 md:w-96 flex flex-row h-5  justify-between  text-gray-200 mx-auto border-gray-200">
                        <div class="border-2 rounded-2xl  w-8 h-8">
                            <div class="border-2 mx-auto  rounded-xl bg-white w-5 h-5"></div>
                        </div>
                        <div class="border-2 rounded-2xl  w-8 h-8">
                            <div class="border-2 mx-auto  rounded-xl bg-blue-500 w-5 h-5"></div>
                        </div>
                        <div class="border-2 rounded-2xl  w-8 h-8">
                            <div class="border-2 mx-auto  rounded-xl bg-white w-5 h-5"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid md:grid-cols-3 sm:m-16 gap-8">
                <div class="md:col-span-1 ">
                    <depProfile :name="departmenthead.name" :position="departmenthead.position"
                        :mobile="departmenthead.phone_no" :email="departmenthead.email"
                        :profile="departmenthead.profile" />
                </div>
                <div class="md:col-span-2">
                        <div class="lg:flex  lg:flex-row gap-8 m-8">
                            <img src="asset/images/binocular.png" class="w-16 h-16  rounded-full" alt="">
                            <div>
                                <h1 class="font-bold text-2xl text-sky-500">Vision</h1>
                                <p class="font-roboto text-md pt-4">{{departmenthead.vission}}</p>
                            </div>
                        </div>
                        <div class="lg:flex  lg:flex-row gap-8 m-8">
                            <img src="asset/images/bulb.jpg" class="w-16 h-16 rounded-full" alt="">
                            <div>
                                <h1 class="font-bold text-2xl text-red-500">Mission</h1>
                                <p class="font-roboto text-md pt-4"> {{departmenthead.mission}} </p>
                            </div>
                        </div>
                        <div class="lg:flex  lg:flex-row gap-8 m-8">
                            <img src="asset/images/goal.png" class="w-16 h-16 rounded-full" alt="">
                            <div>
                                <h1 class="font-bold text-2xl text-gray-950">Goal</h1>
                                <p class="font-roboto text-md pt-4">{{departmenthead.goal}}</p>
                            </div>
                        </div>
                    <!-- service -->
                    <div class="mt-4">
                        <h1 class="font-bold bg-gray-100 p-2  text-3xl">our service</h1>
                        <div v-for="service in  services" :key="service.id">
                            <div v-if="service.department == 'expansion'"
                                class="p-2 flex flex-row gap-3 hover:border-sky-100 hover:border-b w-full md:mt-0 hover:ml-4 mt-3 m-3 xl:p-0">
                                <i class="material-icons p-2 text-orange-300">done</i>
                                <p class=" font-roboto text-md p-2 ">{{ service.service }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- service -->
                </div>
            </div>
        </div>
    </div>
</template>


