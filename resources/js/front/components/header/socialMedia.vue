<script setup>
import lang from "./lang.vue";
</script>

<template>
    <div class="w-full bg-briteblue border-b-2 border-green-100 top-0">
        <div class="flex flex-wrap items-center justify-between px-4 py-2">
            <!-- Contact Info Section -->
            <div class="w-full md:w-fit text-sm text-white font-semibold py-2">
                <div class="flex items-center justify-center gap-3 py-1">
                    <i class="fas fa-map-marker-alt text-lg"></i>
                    <span class="text-lg">Kombolcha, Ethiopia</span>
                    <i class="fas fa-envelope text-lg"></i>
                    <span class="text-lg">kochinvest12@gmail.com</span>
                    <i class="fas fa-phone-alt text-lg"></i>
                    <span class="text-lg">+25197 585 6741</span>
                </div>
            </div>

            <!-- Social Links Section -->
            <div class="w-full md:w-fit">
                <ul
                    class="flex flex-wrap justify-center md:justify-end list-none space-x-6"
                >
                    <!-- Telegram Icon -->
                    <li>
                        <a
                            href="https://t.me/kombolchaindustryandinvestment"
                            class="text-sm font-semibold py-1 px-3 text-white hover:text-green-400 transition-all duration-300 text-xl"
                        >
                            <i class="fab fa-telegram-plane"></i>
                        </a>
                    </li>

                    <!-- Facebook Icon -->
                    <li>
                        <a
                            href="https://web.facebook.com/profile.php?id=100081126495660"
                            class="text-sm font-semibold py-1 px-3 text-white hover:text-green-400 transition-all duration-300 text-xl"
                        >
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>

                    <!-- YouTube Icon -->
                    <li>
                        <a
                            href="https://www.youtube.com/@kombolchacityindustryandin1377"
                            class="text-sm font-semibold py-1 px-3 text-white hover:text-green-400 transition-all duration-300 text-xl"
                        >
                            <i class="fab fa-youtube"></i>
                        </a>
                    </li>

                    <!-- Twitter Icon -->
                    <li>
                        <a
                            href="#"
                            class="text-sm font-semibold py-1 px-3 text-white hover:text-green-400 transition-all duration-300 text-xl"
                        >
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>

                    <!-- <li class="pl-4">
                        <lang />
                    </li> -->
                </ul>
            </div>
        </div>
    </div>
</template>
