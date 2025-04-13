<script setup>
import { ref, computed } from "vue";
import { useI18n } from "vue-i18n"; 

const { t, locale } = useI18n();
 
const menuOpen = ref(false);
const depClass = ref("");
const dropdownOpen = ref(false);

const toggleMenu = () => {
    menuOpen.value = !menuOpen.value;
    if (!menuOpen.value) {
        depClass.value = "";
        dropdownOpen.value = false;
    }
};
const closeMenu = () => {
    menuOpen.value = false;
    depClass.value = "";
    dropdownOpen.value = false;
};
 
const currentLanguageName = computed(() =>
    locale.value === "en" ? "English" : "አማርኛ"
);
const setLanguage = (lang) => {
    locale.value = lang;
    dropdownOpen.value = false;
    closeMenu();
};
</script>

<template>
    <header class="bg-briteblue text-white w-full shadow-md">
        <nav class="max-w-screen-xl mx-auto px-4 py-3 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <img src="/asset/errorimage/logo.png" alt="Logo" class="h-10 w-auto" />
            </div>

            <!-- Desktop Nav -->
            <div class="hidden lg:flex items-center gap-6 font-semibold text-white">
                <a class="nav-link" href="#">{{ t("Home") }}</a>
 
                <router-link class="nav-link" to="/expansion"  >  {{ t("Departments") }}</router-link>
                <router-link class="nav-link" to="/aboutdeps">{{ t("About us") }}</router-link>
                <router-link class="nav-link" to="/Aboutekocha">{{ t("Kocha") }}</router-link>
                <router-link class="nav-link" to="/getourwork">{{ t("Our works") }}</router-link>
                <router-link class="nav-link" to="/contact">{{ t("Contact us") }}</router-link>
                <router-link class="nav-link" to="/resource">{{ t("Resource") }}</router-link>

                <!-- Language Switcher -->
                <div class="relative group">
                    <button
                        class="bg-white text-gray-800 px-3 py-1 rounded-md flex items-center gap-1 hover:bg-gray-100">
                        {{ currentLanguageName }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div :class="[
                        'dropdown-panel right-0',
                        dropdownOpen ? 'show' : '',
                    ]" @mouseenter="dropdownOpen = true" @mouseleave="dropdownOpen = false">
                        <ul class="text-gray-700">
                            <li>
                                <a href="#" @click.prevent="setLanguage('en')" class="dropdown-item">English</a>
                            </li>
                            <li>
                                <a href="#" @click.prevent="setLanguage('am')" class="dropdown-item">አማርኛ</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Mobile Toggle -->
            <button @click="toggleMenu" class="lg:hidden text-white text-3xl focus:outline-none">
                <i class="material-icons">{{ menuOpen ? "close" : "menu" }}</i>
            </button>
        </nav>

        <!-- Mobile Nav Menu -->
        <transition name="slide-fade">
            <div v-show="menuOpen"
                class="lg:hidden bg-briteblue flex flex-col gap-3 px-4 pb-4 text-white font-semibold">
                <a class="nav-link" href="#" >{{
                    t("Home")
                    }}</a>

                <router-link class="nav-link" to="/expansion"  >  {{ t("Departments") }}</router-link>
                <router-link class="nav-link" to="/aboutdeps" >{{ t("About us") }}</router-link>
                <router-link class="nav-link" to="/Aboutekocha" >{{ t("Kocha") }}</router-link>
                <router-link class="nav-link" to="/getourwork" >{{ t("Our works") }}</router-link>
                <router-link class="nav-link" to="/contact" >{{ t("Contact us") }}</router-link>
                <router-link class="nav-link" to="/resource" >{{ t("Resource") }}</router-link>

                <!-- Mobile Language Switch -->
                <div class="relative mt-2">
                    <button
                        class="bg-white text-gray-800 px-3 py-1 rounded-md w-full flex items-center justify-between hover:bg-gray-100"
                        @click="dropdownOpen = !dropdownOpen">
                        {{ currentLanguageName }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div v-show="dropdownOpen" class="dropdown-panel w-full text-black bg-white">
                        <ul>
                            <li>
                                <a href="#" @click.prevent="setLanguage('en')" class="dropdown-item">English</a>
                            </li>
                            <li>
                                <a href="#" @click.prevent="setLanguage('am')" class="dropdown-item">አማርኛ</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </transition>
    </header>
</template>

<style scoped>
.nav-link {
    @apply block px-3 py-2 hover:text-yellow-300 hover:scale-105 transition-transform;
}

.dropdown-panel {
    @apply absolute mt-2 w-48 rounded-md shadow-lg opacity-0 scale-95 invisible transition-all duration-300 transform z-50;
}

.dropdown-panel.show,
.dropdown-panel[v-show="true"] {
    @apply opacity-100 scale-100 visible;
}

.dropdown-item {
    @apply block px-4 py-2 hover:bg-blue-100 transition duration-200;
}

.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.3s ease;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
</style>
