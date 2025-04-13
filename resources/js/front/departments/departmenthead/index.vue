<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import depProfile from "../components/depProfile.vue";

const departments = ref([]);
const services = ref([]);

onMounted(async () => {
    try {
        const deptRes = await axios.get("./api/getall/department");
        departments.value = deptRes.data.DepartmentContent;

        const serviceRes = await axios.get("./api/service/getall");
        services.value = serviceRes.data.services;
    } catch (error) {
        console.error(error);
    }
});
</script>

<template>
    <div
        v-for="departmenthead in departments.data"
        :key="departmenthead.id"
        class="font-roboto"
    >
        <div v-if="departmenthead.position === 'deparment head'">
            <!-- Hero Header -->
            <div
                class="w-full bg-gradient-to-r from-blue-900 to-sky-600 flex flex-col justify-center items-center text-white text-center px-4"
            >
                <h1
                    class="text-3xl md:text-4xl font-bold drop-shadow-sm text-gray-800 pt-8"
                >
                    Kombolcha Investment Office
                </h1>
            </div>

            <!-- Main Content Grid -->
            <div
                class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 p-6 sm:p-12"
            >
                <!-- Profile Card -->
                <div>
                    <depProfile
                        :name="departmenthead.name"
                        :position="departmenthead.position"
                        :mobile="departmenthead.phone_no"
                        :email="departmenthead.email"
                        :profile="departmenthead.profile"
                    />
                </div>

                <!-- Vision, Mission, Goal Section -->
                <div
                    class="md:col-span-2 bg-white shadow-xl rounded-2xl p-8 space-y-12"
                >
                    <!-- VISION -->
                    <div class="text-center space-y-4">
                        <div class="flex justify-center">
                            <img
                                src="asset/images/binocular.png"
                                class="w-20 h-20 rounded-full shadow-lg border-4 border-blue-200"
                                alt="Vision"
                            />
                        </div>
                        <h2
                            class="text-3xl font-extrabold text-sky-600 tracking-wide"
                        >
                            Vision
                        </h2>
                        <p
                            class="text-gray-700 text-md md:text-lg leading-relaxed text-start"
                        >
                            {{ departmenthead.vission }}
                        </p>
                    </div>

                    <!-- MISSION -->
                    <div class="text-center space-y-4">
                        <div class="flex justify-center">
                            <img
                                src="asset/images/bulb.jpg"
                                class="w-20 h-20 rounded-full shadow-lg border-4 border-red-200"
                                alt="Mission"
                            />
                        </div>
                        <h2
                            class="text-3xl font-extrabold text-red-500 tracking-wide"
                        >
                            Mission
                        </h2>
                        <p
                            class="text-gray-700 text-md md:text-lg leading-relaxed text-start"
                        >
                            {{ departmenthead.mission }}
                        </p>
                    </div>

                    <!-- GOAL -->
                    <div class="text-center space-y-4">
                        <div class="flex justify-center">
                            <img
                                src="asset/images/goal.png"
                                class="w-20 h-20 rounded-full shadow-lg border-4 border-green-200"
                                alt="Goal"
                            />
                        </div>
                        <h2
                            class="text-3xl font-extrabold text-green-600 tracking-wide"
                        >
                            Goal
                        </h2>
                        <p
                            class="text-gray-700 text-md md:text-lg leading-relaxed text-start"
                        >
                            {{ departmenthead.goal }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
