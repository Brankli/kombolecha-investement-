<script setup>
import name from "../../../components/name.vue";
import axios from "axios";
import { onMounted, ref } from "vue";
const contents = ref([]);
const departments = ref([]);

onMounted(async () => {
    await axios.get('./api/getall/content').then(res => {
        contents.value = res.data.WebContents;
    }).catch(err => console.log(err));
    await axios.get('./api/getall/department').then(res => {
        departments.value = res.data.DepartmentContent;
    }).catch(err => console.log(err));
});
</script>

<template>
    <div class="bg-gray-100 mb-24">
        <name name="Web Contents" />
        <div class="m-4 hidden rounded">
            <div class="w-full bg-white border-b-2 rounded border-gray-200 flex flex-row justify-between">
                <h1 class="font-bold text-gray-500 text-lg p-4 capitalize">web content</h1>
            </div>
            <!-- table start here -->
            <div class="flex bg-white flex-col items-center justify-center">
                <div class=" w-full  relative p-2 overflow-x-auto shadow-md sm:rounded-lg xs:p-5">
                    <table class="w-full z-0 text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-all-search" type="checkbox"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-sky-500 focus:ring-2 ">
                                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    logo
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    email
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    phone number
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    amaharic name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    edit
                                </th>
                            </tr>
                        </thead>
                        <tbody v-for="content in contents.data" :key="content.id">
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-search-1" type="checkbox"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <img :src="content.logo" class="h-10 w-10 object-cover" alt="logo">
                                </th>
                                <td class="px-6 py-4">
                                    {{ content.name.slice(0, 30) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ content.email.slice(0, 30) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ content.phone_no }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ content.amharicname }}
                                </td>
                                <td class="px-6 py-4">
                                    <router-link :to="{ name: 'editweb', params: { id: content.id } }"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">edit</router-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <!-- department table start here -->
        <div class="m-4 mt-16 rounded">
            <div class="w-full bg-white border-b-2 rounded border-gray-200 flex flex-row justify-between">
                <h1 class="font-bold text-gray-500 text-lg p-4 capitalize">Departments content</h1>
            </div>
            <!-- table start here -->
            <div class="flex bg-white flex-col items-center justify-center">
                <div class=" w-full  relative p-2 overflow-x-auto shadow-md sm:rounded-lg xs:p-5">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    profile
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    d. name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    position
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    email
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    phone number
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    mission
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    vission
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    goal
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    edit
                                </th>
                            </tr>
                        </thead>
                        <tbody v-for="department in departments.data" :key="department.id">
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    <img :src="department.profile" class="h-10 w-10 object-cover" alt="profile">
                                </th>
                                <td class="px-6 py-4">
                                    {{ department.name.slice(0, 15) }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ department.position.slice(0, 10) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ department.email.slice(0, 10) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ department.phone_no.slice(0, 10) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ department.mission.slice(0, 10) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ department.vission.slice(0, 10) }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ department.goal.slice(0, 10) }}
                                </td>
                                <td class="px-6 py-4">
                                    <router-link :to="{ name: 'editdepartment', params: { id: department.id } }"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">edit
                                    </router-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>

            <!-- department table end here -->

        </div>
    </div>
</template>

