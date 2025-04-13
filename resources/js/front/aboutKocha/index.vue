<script setup>
import AboutKoch from "./AboutKoch.vue";
</script>

<template>
    <div class="bg-white w-full pb-20 text-black">
        <!-- Page Title -->
        <h1 class="text-center p-4 text-4xl text-gray-800 mb-8 font-extrabold">
            About Kombolcha
        </h1>

        <!-- Side-by-side Text + Image Section -->
        <div
            class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-2 gap-10 items-center"
        >
            <!-- Text Column -->
            <div>
                <h2 class="text-3xl font-bold text-sky-500 mb-4">
                    Discover Kombolcha
                </h2>
                <p class="text-lg text-gray-600 leading-relaxed">
                    Kombolcha, located in the northeastern part of Ethiopia, is
                    a rapidly developing industrial and commercial hub. With its
                    strategic location along the Ethiopia–Djibouti trade
                    corridor and the presence of key infrastructure such as a
                    dry port, highways, and an airport, Kombolcha serves as a
                    gateway for domestic and international trade. The city is
                    also home to the Kombolcha Industrial Park, attracting
                    investors from around the globe.
                </p>
                <p class="text-lg text-gray-600 mt-4 leading-relaxed">
                    Renowned for its peace, skilled workforce, and natural
                    resources, Kombolcha offers a welcoming environment for
                    businesses and a promising future for development. Its
                    growing reputation as an investment destination makes it a
                    key player in Ethiopia’s economic transformation.
                </p>
            </div>

            <!-- Image Column -->
            <div class="w-full h-full">
                <img
                    src="asset/images/Invest-kombolcha.png"
                    alt="Invest in Kombolcha"
                    class="w-full h-80 object-contain"
                />
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="max-w-7xl mx-auto mt-12 px-4">
            <AboutKoch />
        </div>
    </div>
</template>
