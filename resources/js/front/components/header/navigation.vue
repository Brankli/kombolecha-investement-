<script setup>
import { ref, computed } from "vue";
import { useI18n } from "vue-i18n";

const { t, locale } = useI18n();

// mobile nav open?
const menuOpen = ref(false);
// desktop lang menu
const langDropdownDesktop = ref(false);
// mobile lang menu
const langDropdownMobile = ref(false);

const toggleMenu = () => {
    menuOpen.value = !menuOpen.value;
    if (!menuOpen.value) {
        // whenever mobile nav closes, also hide its lang dropdown
        langDropdownMobile.value = false;
    }
};

const closeMenu = () => {
    menuOpen.value = false;
    langDropdownMobile.value = false;
};

const currentLanguageName = computed(() =>
    locale.value === "en" ? "English" : "አማርኛ"
);

// toggle desktop language dropdown
const toggleLangDesktop = (e) => {
    langDropdownDesktop.value = !langDropdownDesktop.value;
};

// toggle mobile language dropdown
const toggleLangMobile = () => {
    langDropdownMobile.value = !langDropdownMobile.value;
};

const setLanguage = (lang) => {
    locale.value = lang;
    // hide both language dropdowns
    langDropdownDesktop.value = false;
    langDropdownMobile.value = false;
    // if you’re on mobile, also close the whole menu
    closeMenu();
};
</script>

<template>
    <header class="bg-briteblue text-white w-full shadow-md">
        <nav
            class="max-w-screen-xl mx-auto px-4 flex justify-between items-center"
        >
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <img
                    src="/asset/errorimage/logo.png"
                    alt="Logo"
                    class="w-16 h-16 rounded-full"
                />
            </div>

            <!-- Desktop Nav -->
            <div
                class="hidden lg:flex items-center gap-6 font-semibold text-white"
            >
                <router-link class="nav-link" to="/">{{
                    t("Home")
                }}</router-link>
                <router-link class="nav-link" to="/expansion">{{
                    t("Departments")
                }}</router-link>
                <router-link class="nav-link" to="/aboutdeps">{{
                    t("About us")
                }}</router-link>
                <router-link class="nav-link" to="/Aboutekocha">{{
                    t("Kombolcha")
                }}</router-link>
                <router-link class="nav-link" to="/getourwork">{{
                    t("Our works")
                }}</router-link>
                <router-link class="nav-link" to="/contact">{{
                    t("Contact us")
                }}</router-link>
                <router-link class="nav-link" to="/resource">{{
                    t("Resource")
                }}</router-link>

                <!-- Desktop Language Switcher -->
                <div class="relative" @click.stop>
                    <button
                        @click="toggleLangDesktop"
                        class="bg-white text-gray-800 px-3 py-1 rounded-md flex items-center gap-1 hover:bg-gray-100"
                    >
                        {{ currentLanguageName }}
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>
                    <div
                        v-show="langDropdownDesktop"
                        class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white text-gray-700 z-50"
                    >
                        <ul>
                            <li>
                                <a
                                    href="#"
                                    @click.prevent="setLanguage('en')"
                                    class="dropdown-item"
                                    >English</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    @click.prevent="setLanguage('am')"
                                    class="dropdown-item"
                                    >አማርኛ</a
                                >
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Mobile Toggle -->
            <button
                @click="toggleMenu"
                class="lg:hidden text-white text-2xl font-bold focus:outline-none"
            >
                <i :class="menuOpen ? 'fas fa-times' : 'fas fa-bars'"></i>
            </button>
        </nav>

        <!-- Mobile Nav Menu -->
        <transition name="slide-fade">
            <div
                v-show="menuOpen"
                class="lg:hidden border-t-2 border-orange-500 bg-briteblue flex flex-col gap-3 px-4 pb-4 text-white font-semibold"
            >
                <router-link @click="closeMenu" class="nav-link" to="/">{{
                    t("Home")
                }}</router-link>
                <router-link
                    @click="closeMenu"
                    class="nav-link"
                    to="/expansion"
                    >{{ t("Departments") }}</router-link
                >
                <router-link
                    @click="closeMenu"
                    class="nav-link"
                    to="/aboutdeps"
                    >{{ t("About us") }}</router-link
                >
                <router-link
                    @click="closeMenu"
                    class="nav-link"
                    to="/Aboutekocha"
                    >{{ t("Kombolcha") }}</router-link
                >
                <router-link
                    @click="closeMenu"
                    class="nav-link"
                    to="/getourwork"
                    >{{ t("Our works") }}</router-link
                >
                <router-link
                    @click="closeMenu"
                    class="nav-link"
                    to="/contact"
                    >{{ t("Contact us") }}</router-link
                >
                <router-link
                    @click="closeMenu"
                    class="nav-link"
                    to="/resource"
                    >{{ t("Resource") }}</router-link
                >

                <!-- Mobile Language Switch -->
                <div class="relative mt-2">
                    <button
                        @click="toggleLangMobile"
                        class="bg-white text-gray-800 px-3 py-1 rounded-md w-full flex items-center justify-between hover:bg-gray-100"
                    >
                        {{ currentLanguageName }}
                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>
                    <div
                        v-show="langDropdownMobile"
                        class="mt-1 w-full rounded-md shadow-lg bg-white text-gray-800"
                    >
                        <ul>
                            <li>
                                <a
                                    href="#"
                                    @click.prevent="setLanguage('en')"
                                    class="dropdown-item"
                                    >English</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    @click.prevent="setLanguage('am')"
                                    class="dropdown-item"
                                    >አማርኛ</a
                                >
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
    @apply block px-3 py-2 hover:text-orange-400 hover:scale-105 transition-transform;
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
