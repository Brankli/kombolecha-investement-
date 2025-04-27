<template>
    <div class="bg-gray-100 mb-24">
        <!-- Header -->
        <name name="Dashboard" />

        <!-- Stats Cards -->
        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 sm:m-8">
            <!-- Visitor Card -->
            <div
                class="w-full shadow bg-white flex justify-between border-2 rounded-md m-4 p-4"
            >
                <div>
                    <h2 class="text-xl text-gray-400">Total Visitor</h2>
                    <p class="text-3xl text-sky-800">{{ allvisitor }}</p>
                </div>
                <i
                    class="fas fa-users text-sky-700 text-2xl bg-sky-200 p-2 rounded-md"
                ></i>
            </div>

            <!-- Subscriber Card -->
            <div
                class="w-full shadow bg-white flex justify-between border-2 rounded-md m-4 p-4"
            >
                <div>
                    <h2 class="text-xl text-gray-400">Total Subscriber</h2>
                    <p class="text-3xl text-sky-800">{{ allsubscribers }}</p>
                </div>
                <i
                    class="fas fa-user-friends text-sky-700 text-2xl bg-sky-200 p-2 rounded-md"
                ></i>
            </div>

            <!-- Question Card -->
            <div
                class="w-full shadow bg-white flex justify-between border-2 rounded-md m-4 p-4"
            >
                <div>
                    <h2 class="text-xl text-gray-400">Total Question</h2>
                    <p class="text-3xl text-sky-800">{{ countallquestions }}</p>
                </div>
                <i
                    class="fas fa-question-circle text-sky-700 text-2xl bg-sky-200 p-2 rounded-md"
                ></i>
            </div>
        </div>

        <!-- Question Table -->
        <div class="m-4 rounded">
            <div
                class="w-full bg-white border-b-2 rounded border-gray-200 flex justify-between"
            >
                <h1 class="font-bold text-gray-500 text-lg p-4 capitalize">
                    Question table
                </h1>
            </div>

            <div class="flex bg-white flex-col items-center justify-center">
                <div
                    class="w-full relative p-2 overflow-x-auto shadow-md sm:rounded-lg xs:p-5"
                >
                    <!-- Search -->
                    <div
                        class="flex flex-col sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4"
                    >
                        <div></div>
                        <label for="table-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none"
                            >
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <input
                                id="table-search"
                                v-model="keywords"
                                @input="currentPage = 1"
                                type="text"
                                class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-sky-500 focus:border-sky-500 outline-none"
                                placeholder="Search for items"
                            />
                        </div>
                    </div>

                    <!-- Details Modal -->
                    <questionDisplay
                        v-if="readQuestion"
                        :class="className"
                        :question="readQuestion.question"
                        @click.prevent="toggleQuestion"
                    />

                    <!-- Table -->
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50"
                        >
                            <tr>
                                <th class="p-4">View</th>
                                <th class="px-6 py-3">Question</th>
                                <th class="px-6 py-3">Email</th>
                                <th class="px-6 py-3">Phone</th>
                                <th class="px-6 py-3">Date</th>
                                <th class="px-6 py-3">Answered</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="q in paginatedData"
                                :key="q.id"
                                class="bg-white border-b hover:bg-gray-50"
                            >
                                <td class="w-4 p-4">
                                    <i
                                        class="material-icons text-green-700 cursor-pointer"
                                        @click="viewquestion(q.id)"
                                        >visibility_off</i
                                    >
                                </td>
                                <td
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                >
                                    {{ q.question.slice(0, 30) }}…
                                </td>
                                <td class="px-6 py-4">
                                    {{ q.email.slice(0, 15) }}…
                                </td>
                                <td class="px-6 py-4">
                                    {{ q.phone_no.slice(0, 15) }}…
                                </td>
                                <td class="px-6 py-4">
                                    {{ formatDate(q.created_at) }}
                                </td>
                                <td class="px-6 py-4">
                                    <i
                                        v-if="q.is_answered === 'yes'"
                                        class="material-icons text-primary"
                                        >mark_email_read</i
                                    >
                                    <router-link
                                        v-else
                                        :to="{
                                            name: 'answer',
                                            params: { id: q.id },
                                        }"
                                    >
                                        <i class="material-icons text-green-700"
                                            >unsubscribe</i
                                        >
                                    </router-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div
                        v-if="totalPages > 1"
                        class="w-full flex justify-center gap-2 pt-4"
                    >
                        <button
                            class="shadow p-2 bg-gray-200 hover:bg-gray-300 text-lg font-bold rounded disabled:opacity-50"
                            @click="prevPage"
                            :disabled="currentPage === 1"
                        >
                            Back
                        </button>
                        <span class="p-2 text-lg font-bold"
                            >Page {{ currentPage }}</span
                        >
                        <button
                            class="shadow p-2 bg-gray-200 hover:bg-gray-300 text-lg font-bold rounded disabled:opacity-50"
                            @click="nextPage"
                            :disabled="currentPage === totalPages"
                        >
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { onMounted, ref, computed } from "vue";
import name from "./components/name.vue";
import questionDisplay from "./pages/question/question.vue";
import { format, parseISO } from "date-fns";

// 1. Grab the raw token (no “Bearer ” prefix yet)
import { useLocalStorage } from "@vueuse/core";

const token = useLocalStorage("token", "");
const allvisitor = ref(0);
const allsubscribers = ref(0);
const countallquestions = ref(0);
const allquestions = ref([]);
const readQuestion = ref(null);
const className = ref("hidden");
const keywords = ref("");
const perPage = ref(5);
const currentPage = ref(1);

// 3. Format dates
const formatDate = (iso) => format(parseISO(iso), "yyyy-MM-dd");

// 4. On mount: set header, record, then fetch
onMounted(async () => {
    axios.defaults.headers.common[
        "Authorization"
    ] = `Bearer ${token.value.replace(/^Bearer\s+/i, "")}`;

    // B) Record the visit (ignore failures)
    axios.post("/api/visitor").catch(() => {
        console.warn("Visitor record failed");
    });

    // C) Fetch visitor count
    try {
        // Always set Authorization header properly
        axios.defaults.headers.common[
            "Authorization"
        ] = `Bearer ${token.value.replace(/^Bearer\s+/i, "")}`;

        // Fetch visitor count
        const response = await axios.get("/api/countvisitor");
        allvisitor.value = response.data.count;
    } catch (error) {
        console.error("Failed to load visitor count:", error);
    }

    // D) Fetch subscriber count
    try {
        const s = await axios.get("/api/subscriber/getall");
        allsubscribers.value = s.data.subscribers;
    } catch (e) {
        console.error("Subscriber fetch failed", e);
    }

    // E) Fetch question count
    try {
        const qcount = await axios.get("/api/count/question");
        countallquestions.value = qcount.data;
    } catch (e) {
        console.error("Question count fetch failed", e);
    }

    // F) Fetch all questions
    try {
        const res = await axios.get("/api/getall/question");
        allquestions.value = res.data;
    } catch (e) {
        console.error("Questions fetch failed", e);
    }
});

// View and toggle question details
function viewquestion(id) {
    readQuestion.value = allquestions.value.find((q) => q.id === id);
    className.value = "unhide";
}
function toggleQuestion() {
    className.value = className.value === "hidden" ? "unhide" : "hidden";
}

// Search + pagination
const filtered = computed(() => {
    const kw = keywords.value.trim().toLowerCase();
    return allquestions.value.filter((q) =>
        q.question.toLowerCase().includes(kw)
    );
});
const totalPages = computed(() =>
    Math.ceil(filtered.value.length / perPage.value)
);
const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    return filtered.value.slice(start, start + perPage.value);
});
function prevPage() {
    if (currentPage.value > 1) currentPage.value--;
}
function nextPage() {
    if (currentPage.value < totalPages.value) currentPage.value++;
}
</script>

<style scoped>
.unhide {
    animation: fadeIn 0.2s ease-out forwards;
}
.hidden {
    display: none;
}
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
</style>
