<script setup>
import lang from "./lang.vue";
</script>

<template>
    <div class="w-full bg-briteblue border-b-2 border-green-100 top-0">
        <div class="flex flex-wrap items-center justify-between px-4 py-2">
            <!-- Contact Info Section -->
            <div class="w-full md:w-fit text-sm text-white font-semibold">
                <div
                    class="flex items-center justify-center gap-3 py-1 flex-wrap"
                >
                    <!-- Location (hidden on mobile) -->
                    <span class="hidden md:flex items-center gap-1">
                        <i class="fas fa-map-marker-alt text-xs"></i>
                        <span class="text-xs">Kombolcha, Ethiopia</span>
                    </span>

                    <!-- Email -->
                    <span class="flex items-center gap-1">
                        <i class="fas fa-envelope text-xs"></i>
                        <span class="text-xs">kochinvest12@gmail.com</span>
                    </span>

                    <!-- Phone -->
                    <span class="flex items-center gap-1">
                        <i class="fas fa-phone-alt text-xs"></i>
                        <span class="text-xs">+25197 585 6741</span>
                    </span>
                </div>
            </div>

            <!-- Social Icons -->
            <div class="w-full md:w-fit">
                <ul
                    class="flex flex-wrap justify-center md:justify-end list-none space-x-3"
                >
                    <li>
                        <a
                            href="https://t.me/kombolchaindustryandinvestment"
                            target="_blank"
                            class="font-semibold py-1 text-white hover:text-green-400 transition-all duration-300 text-xl"
                        >
                            <i class="fab fa-telegram-plane"></i>
                        </a>
                    </li>
                    <li>
                        <a
                            href="https://web.facebook.com/profile.php?id=100081126495660"
                            target="_blank"
                            class="font-semibold py-1 text-white hover:text-green-400 transition-all duration-300 text-xl"
                        >
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                    <li>
                        <a
                            href="https://www.youtube.com/@kombolchacityindustryandin1377"
                            target="_blank"
                            class="font-semibold py-1 text-white hover:text-green-400 transition-all duration-300 text-xl"
                        >
                            <i class="fab fa-youtube"></i>
                        </a>
                    </li>
                    <li>
                        <a
                            href="#"
                            target="_blank"
                            class="font-semibold py-1 px-3 text-white hover:text-green-400 transition-all duration-300 text-xl"
                        >
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
