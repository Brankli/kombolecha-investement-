<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";

const departmentHead = ref(null);
const mineralDirector = ref(null);
const expansionDirector = ref(null);
const developmentDirector = ref(null);

const staffs = ref([]);

function getAllStaff() {
    axios
        .get(`/api/staff/getall`)
        .then((res) => {
            staffs.value = res.data.data;
        })
        .catch((err) => console.log(err));
}

onMounted(async () => {
    await axios
        .get("./api/department-staffs")
        .then((res) => {
            mineralDirector.value = res.data.mineralDirector;
            expansionDirector.value = res.data.expansionDirector;
            developmentDirector.value = res.data.developmentDirector;
            departmentHead.value = res.data.departmentHead;
        })
        .catch((err) => console.log(err));

    getAllStaff();
});
</script>

<template>
    <div class="org-container">
        <header class="org-header">
            <h3>Our Organization</h3>
            <p>
                Meet the dedicated team behind our success — passionate
                professionals committed to excellence.
            </p>
        </header>

        <!-- Organizational Chart -->
        <div class="org-chart">
            <!-- Director Card -->
            <div class="director">
                <div class="card">
                    <img
                        :src="departmentHead?.image"
                        alt="Sector Director"
                        class="profile-img"
                    />
                    <div class="px-6 text-left text-white">
                        <h2 class="font-bold">{{ departmentHead?.name }}</h2>
                        <div class="text-left space-y-2">
                            <p class="text-sm">
                                {{ departmentHead?.position }}
                            </p>
                            <p class="text-sm">
                                <span class="font-medium">Email:</span>
                                {{ departmentHead?.email }}
                            </p>
                            <p class="text-sm">
                                <span class="font-medium">Mobile:</span>
                                {{ departmentHead?.phone_no }}
                            </p>
                            <p class="text-xs">
                                Open: Monday – Friday, 2:00–11:00
                            </p>
                        </div>

                        <!-- CTA -->
                        <div class="my-4">
                            <router-link
                                to="/contact"
                                class="inline-block px-6 py-2 text-sm font-semibold rounded-md text-white bg-yellow-600 hover:bg-yellow-700 transition"
                            >
                                Ask a Question
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vertical Connector -->
            <div class="connector vertical"></div>

            <!-- Sector Directors -->
            <div class="sector-directors">
                <!-- Horizontal Connector -->
                <div class="connector horizontal"></div>
                <div class="cards">
                    <div class="card">
                        <img
                            :src="mineralDirector?.image"
                            alt="Sector Director"
                            class="profile-img"
                        />
                        <div class="px-6 text-left text-white">
                            <h2 class="font-bold">
                                {{ mineralDirector?.name }}
                            </h2>
                            <div class="text-left space-y-2">
                                <p class="text-sm">
                                    {{ mineralDirector?.position }}
                                </p>
                                <p class="text-sm">
                                    <span class="font-medium">Email:</span>
                                    {{ mineralDirector?.email }}
                                </p>
                                <p class="text-sm">
                                    <span class="font-medium">Mobile:</span>
                                    {{ mineralDirector?.phone_no }}
                                </p>
                                <p class="text-xs">
                                    Open: Monday – Friday, 2:00–11:00
                                </p>
                            </div>

                            <!-- CTA -->
                            <div class="my-4">
                                <router-link
                                    to="/contact"
                                    class="inline-block px-6 py-2 text-sm font-semibold rounded-md text-white bg-yellow-600 hover:bg-yellow-700 transition"
                                >
                                    Ask a Question
                                </router-link>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <img
                            :src="expansionDirector?.image"
                            alt="Sector Director"
                            class="profile-img"
                        />
                        <div class="px-6 text-left text-white">
                            <h2 class="font-bold">
                                {{ expansionDirector?.name }}
                            </h2>
                            <div class="text-left space-y-2">
                                <p class="text-sm">
                                    {{ expansionDirector?.position }}
                                </p>
                                <p class="text-sm">
                                    <span class="font-medium">Email:</span>
                                    {{ expansionDirector?.email }}
                                </p>
                                <p class="text-sm">
                                    <span class="font-medium">Mobile:</span>
                                    {{ expansionDirector?.phone_no }}
                                </p>
                                <p class="text-xs">
                                    Open: Monday – Friday, 2:00–11:00
                                </p>
                            </div>

                            <!-- CTA -->
                            <div class="my-4">
                                <router-link
                                    to="/contact"
                                    class="inline-block px-6 py-2 text-sm font-semibold rounded-md text-white bg-yellow-600 hover:bg-yellow-700 transition"
                                >
                                    Ask a Question
                                </router-link>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <img
                            :src="developmentDirector?.image"
                            alt="Sector Director"
                            class="profile-img"
                        />
                        <div class="px-6 text-left text-white">
                            <h2 class="font-bold">
                                {{ developmentDirector?.name }}
                            </h2>
                            <div class="text-left space-y-2">
                                <p class="text-sm">
                                    {{ developmentDirector?.position }}
                                </p>
                                <p class="text-sm">
                                    <span class="font-medium">Email:</span>
                                    {{ developmentDirector?.email }}
                                </p>
                                <p class="text-sm">
                                    <span class="font-medium">Mobile:</span>
                                    {{ developmentDirector?.phone_no }}
                                </p>
                                <p class="text-xs">
                                    Open: Monday – Friday, 2:00–11:00
                                </p>
                            </div>

                            <!-- CTA -->
                            <div class="my-4">
                                <router-link
                                    to="/contact"
                                    class="inline-block px-6 py-2 text-sm font-semibold rounded-md text-white bg-yellow-600 hover:bg-yellow-700 transition"
                                >
                                    Ask a Question
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="workers-section">
            <!-- Connector from sector directors -->
            <div class="connector vertical w-px h-8 bg-gray-300 mx-auto"></div>
            <h3 class="workers-title text-2xl font-bold text-blue-900 my-4">
                Our Staffs
            </h3>
            <div class="workers-grid my-16">
                <!-- Generate 22 worker cards -->
                <div
                    v-for="(staff, index) in staffs"
                    :key="index"
                    class="relative group"
                >
                    <img
                        :src="staff.image"
                        alt="Worker"
                        class="w-24 h-24 rounded-full object-cover mx-auto"
                    />
                    <div class="text-center mt-2">
                        <h2 class="text-blue-900 text-sm font-normal">
                            {{ staff.name }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Container & Header */
.org-container {
    width: 90%;
    margin: 0 auto;
    text-align: center;
    font-family: sans-serif;
}

.org-header h3 {
    font-size: 2.5rem;
    font-weight: 800;
    background: linear-gradient(to right, #84cc16, #10b981);
    -webkit-background-clip: text;
    color: transparent;
    padding: 1rem 0;
}

.org-header p {
    font-size: 1rem;
    color: #6b7280;
}

/* Organizational Chart Layout */
.org-chart {
    position: relative;
    margin-top: 2rem;
}

/* Card Styles */
.card {
    background: linear-gradient(to bottom right, #1e3a8a, #0284c7);
    color: #fff;
    padding: 1.5rem;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: inline-block;
    position: relative;
}

.profile-img {
    width: 9rem;
    height: 9rem;
    border-radius: 50%;
    border: 4px solid #fff;
    object-fit: cover;
    margin: 0 auto;
}

.card h2 {
    font-size: 1.5rem;
    margin-top: 1rem;
    text-transform: capitalize;
}

/* Director Section */
.director {
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Connectors */
.connector.vertical {
    width: 2px;
    height: 2rem;
    background-color: #d1d5db;
    margin: 0 auto;
}

.connector.horizontal {
    position: absolute;
    top: -1rem;
    left: 50%;
    width: 80%;
    height: 2px;
    background-color: #d1d5db;
    transform: translateX(-50%);
}

/* Sector Directors Section */
.sector-directors {
    position: relative;
    margin-top: 1rem;
}

.cards {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    flex-wrap: wrap;
    margin-top: 1rem;
}

/* Workers Section */
.workers-section {
    margin-top: 3rem;
    position: relative;
}

.workers-title {
    font-size: 2rem;
    margin: 1rem 0;
    font-weight: 700;
    color: #1e3a8a;
}

.workers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

/* Optional: Hover Effects */
.card:hover {
    filter: brightness(1.05);
    transition: filter 0.3s ease;
}
</style>
