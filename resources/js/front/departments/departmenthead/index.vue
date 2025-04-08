<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import depProfile from '../components/depProfile.vue';

const departments = ref([]);
const services = ref([]);

onMounted(async()=>{
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
        <div v-if="departmenthead.position === 'deparment head'">
            <div class="  w-screen h-64 bg-darkblue ">
                <div class="text-center  ">
                    <h1 class="text-4xl font-bold p-16 font-roboto rounded-lg text-white">Kombolcha Investment office
                    </h1>
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
            <div class="grid md:grid-cols-3 sm:m-16">
                <div class="md:col-span-1">
                    <depProfile :name="departmenthead.name" :position="departmenthead.position"
                        :mobile="departmenthead.phone_no" :email="departmenthead.email"
                        :profile="departmenthead.profile" />
                </div>
                <div class="md:col-span-2 ">
                    <div class=" text-white rounded-lg p-8">
                        <div class="lg:flex  lg:flex-row gap-8 m-8">
                            <div class="w-full">
                                <img src="asset/images/binocular.png" class="w-16 h-16 mx-auto rounded-full" alt="">
                                <h1 class="font-bold text-2xl text-center text-sky-500">Vision</h1>
                                <p class="font-roboto text-yellow-600 text-center pt-4">{{ departmenthead.vission }}</p>
                            </div>
                        </div>
                        <div class="lg:flex  lg:flex-row gap-8 m-8">
                            <div>
                                <img src="asset/images/bulb.jpg" class="w-16 h-16 mx-auto rounded-full" alt="">
                                <h1 class="font-bold text-2xl text-center text-red-500">Mission</h1>
                                <p class="font-roboto text-yellow-600 text-center pt-4">{{ departmenthead.mission }}</p>
                            </div>
                        </div>
                        <div class="lg:flex  lg:flex-row gap-8 m-8">
                            <div>
                                <img src="asset/images/goal.png" class="w-16 h-16 mx-auto rounded-full" alt="">
                                <h1 class="font-bold text-2xl text-center text-green-500">Goal</h1>
                                <p class="font-roboto text-yellow-600 text-center pt-4">{{ departmenthead.goal }}</p>
                            </div>
                        </div>
                    </div>
                <!-- service table -->
                </div>
            </div>
        </div>
    </div>
</template>


