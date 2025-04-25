<script setup>
import name from "../../../components/name.vue";
import axios from "axios";
import { onMounted, ref } from "vue";

// State
const department = ref({});
const showEdit = ref(false);
const editForm = ref({ mission: "", vision: "", goal: "" });
const loading = ref(false);
const error = ref(null);

// Fetch the single department record on mount
onMounted(fetchDepartment);

async function fetchDepartment() {
    try {
        const res = await axios.get("/api/getall/department");
        // your API returns { data: { ... } }
        department.value = res.data?.data || {};
    } catch (e) {
        console.error("Failed to fetch department:", e);
    }
}

// Enter edit mode and preload form
function enableEdit() {
    editForm.value.mission = department.value.mission;
    editForm.value.vision = department.value.vision;
    editForm.value.goal = department.value.goal;
    error.value = null;
    showEdit.value = true;
}

// Submit updated fields
async function handleEditSubmit() {
    loading.value = true;
    error.value = null;

    try {
        await axios.put(`/api/department/${department.value.id}`, {
            mission: editForm.value.mission,
            vision: editForm.value.vision,
            goal: editForm.value.goal,
        });
        await fetchDepartment();
        showEdit.value = false;
    } catch (e) {
        console.error(e);
        error.value = "Failed to update department.";
    } finally {
        loading.value = false;
    }
}
</script>

<template>
    <div class="bg-gray-100 min-h-screen pb-24">
        <name name="Web Contents" />

        <div class="px-4 pt-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b">
                    <h1 class="text-xl font-semibold text-gray-700">
                        Department Content
                    </h1>
                </div>

                <div class="p-6">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-100"
                        >
                            <tr>
                                <th class="px-4 py-2">Key</th>
                                <th class="px-4 py-2">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3">Mission</td>
                                <td class="px-4 py-3">
                                    <div v-if="!showEdit">
                                        {{ department.mission }}
                                    </div>
                                    <input
                                        v-else
                                        v-model="editForm.mission"
                                        type="text"
                                        class="w-full p-2 border rounded"
                                    />
                                </td>
                            </tr>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3">Vision</td>
                                <td class="px-4 py-3">
                                    <div v-if="!showEdit">
                                        {{ department.vision }}
                                    </div>
                                    <input
                                        v-else
                                        v-model="editForm.vision"
                                        type="text"
                                        class="w-full p-2 border rounded"
                                    />
                                </td>
                            </tr>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3">Goal</td>
                                <td class="px-4 py-3">
                                    <div v-if="!showEdit">
                                        {{ department.goal }}
                                    </div>
                                    <input
                                        v-else
                                        v-model="editForm.goal"
                                        type="text"
                                        class="w-full p-2 border rounded"
                                    />
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="flex justify-end mt-4 space-x-2">
                        <button
                            v-if="!showEdit"
                            @click="enableEdit"
                            class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600"
                        >
                            Edit
                        </button>

                        <template v-else>
                            <button
                                @click="handleEditSubmit"
                                :disabled="loading"
                                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                            >
                                {{ loading ? "Saving..." : "Save" }}
                            </button>
                            <button
                                @click="showEdit = false"
                                class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500"
                            >
                                Cancel
                            </button>
                        </template>
                    </div>

                    <p v-if="error" class="text-red-600 mt-2">{{ error }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
