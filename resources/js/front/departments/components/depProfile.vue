<script setup>
const props = defineProps({
    name: "",
    position: "",
    email: "",
    mobile: "",
    profile: "",
});
</script>

<template>
    <div
        class="rounded-2xl shadow-lg overflow-hidden bg-white transition hover:shadow-2xl duration-300"
    >
        <!-- Profile Image -->
        <div class="bg-gradient-to-br from-darkblue to-sky-800 p-6 text-center">
            <img
                :src="props.profile"
                alt="Profile"
                class="w-36 h-36 mx-auto rounded-full border-4 border-white object-cover shadow-md"
            />
            <h2
                class="text-white text-2xl font-semibold mt-4 tracking-wide capitalize"
            >
                {{ props.name }}
            </h2>
            <p class="text-sky-600 text-sm uppercase mt-1 tracking-wide">
                {{ props.position }}
            </p>
        </div>

        <!-- Info Section -->
        <div class="p-6 text-center space-y-2 bg-gray-50">
            <p class="text-gray-700 text-sm">
                <span class="font-medium">Email:</span> {{ props.email }}
            </p>
            <p class="text-gray-700 text-sm">
                <span class="font-medium">Mobile:</span> {{ props.mobile }}
            </p>
            <p class="text-gray-600 text-xs">
                Open: Monday – Friday, 2:00–11:00
            </p>

            <!-- CTA -->
            <router-link
                to="/contact"
                class="inline-block mt-4 px-6 py-2 text-sm font-semibold rounded-md text-white bg-blue-600 hover:bg-blue-700 transition"
            >
                Ask a Question
            </router-link>
        </div>
    </div>
</template>
