<script setup>
import subscribe from "./subscrib.vue";
</script>

<template>
    <footer class="bg-cyan-950 text-white pt-10 font-roboto text-sm w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- About -->
                <div>
                    <h2
                        class="text-blue-400 text-lg md:text-xl font-bold mb-4 uppercase"
                    >
                        {{ $t("lang.About KIID") }}
                    </h2>
                    <ul class="space-y-2">
                        <li>
                            <a
                                href="#"
                                class="hover:text-blue-200 text-sm md:text-base"
                            >
                                {{ $t("lang.Overview") }}
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="hover:text-blue-200 text-sm md:text-base"
                            >
                                {{ $t("lang.Mission") }}
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="hover:text-blue-200 text-sm md:text-base"
                            >
                                {{ $t("lang.Vision") }}
                            </a>
                        </li>
                    </ul>

                    <h2
                        class="text-blue-400 text-lg md:text-xl font-bold mt-6 mb-4 uppercase"
                    >
                        {{ $t("lang.About KC") }}
                    </h2>
                    <ul class="space-y-2">
                        <li>
                            <a
                                href="#"
                                class="hover:text-blue-200 text-sm md:text-base"
                            >
                                {{ $t("lang.history") }}
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="hover:text-blue-200 text-sm md:text-base"
                            >
                                {{ $t("lang.geolocation") }}
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="hover:text-blue-200 text-sm md:text-base"
                            >
                                {{ $t("lang.weather") }}
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="hover:text-blue-200 text-sm md:text-base"
                            >
                                {{ $t("lang.compAdvantage") }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Our Works -->
                <div>
                    <h2
                        class="text-blue-400 text-lg md:text-xl font-bold mb-4 uppercase"
                    >
                        {{ $t("lang.our works") }}
                    </h2>
                    <ul class="space-y-2">
                        <li>
                            <a
                                href="#"
                                class="hover:text-blue-200 text-sm md:text-base"
                            >
                                {{ $t("lang.agro process") }}
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="hover:text-blue-200 text-sm md:text-base"
                            >
                                {{ $t("lang.fabricate leather") }}
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="hover:text-blue-200 text-sm md:text-base"
                            >
                                {{ $t("lang.textile and cloth sec") }}
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="hover:text-blue-200 text-sm md:text-base"
                            >
                                {{ $t("lang.wood sec") }}
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="hover:text-blue-200 text-sm md:text-base"
                            >
                                {{ $t("lang.const sec") }}
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="hover:text-blue-200 text-sm md:text-base"
                            >
                                {{ $t("lang.social sector") }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Departments & Subscribe -->
                <div>
                    <h2
                        class="text-blue-400 text-lg md:text-xl font-bold mb-4 uppercase"
                    >
                        {{ $t("lang.Departments") }}
                    </h2>
                    <ul class="space-y-2">
                        <li>
                            <a
                                href="#"
                                class="hover:text-blue-200 text-sm md:text-base"
                            >
                                {{ $t("lang.expInvestment") }}
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="hover:text-blue-200 text-sm md:text-base"
                            >
                                {{ $t("lang.industrydev") }}
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="hover:text-blue-200 text-sm md:text-base"
                            >
                                {{ $t("lang.mining opma") }}
                            </a>
                        </li>
                    </ul>

                    <div class="mt-6">
                        <h2 class="text-white text-lg md:text-xl font-bold">
                            {{ $t("lang.join us") }}
                        </h2>
                        <p class="text-sm md:text-base text-gray-300 mb-4">
                            {{ $t("lang.email and subscribe") }}
                        </p>
                        <subscribe />
                    </div>
                </div>
            </div>

            <!-- Social & Links -->
            <div
                class="mt-10 border-t border-gray-700 pt-6 flex flex-col md:flex-row justify-between items-center"
            >
                <!-- Social icons only -->
                <div class="flex gap-4 mb-4 md:mb-0 text-xl">
                    <a
                        href="https://t.me/kombolchaindustryandinvestment"
                        target="_blank"
                        class="hover:text-blue-400"
                        title="Telegram"
                    >
                        <i class="fab fa-telegram"></i>
                    </a>
                    <a
                        href="https://www.facebook.com/p/Kombolcha-industry-and-investment-department-100080887707066/"
                        target="_blank"
                        class="hover:text-blue-400"
                        title="Facebook"
                    >
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a
                        href="https://www.youtube.com/@kombolchacityindustryandin1377"
                        target="_blank"
                        class="hover:text-red-500"
                        title="YouTube"
                    >
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a
                        href="https://twitter.com"
                        target="_blank"
                        class="hover:text-blue-400"
                        title="Twitter"
                    >
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>

                <!-- Bottom links -->
                <ul class="flex flex-wrap gap-4 text-sm md:text-base">
                    <li>
                        <a href="#" class="hover:text-blue-200">{{
                            $t("lang.News")
                        }}</a>
                    </li>
                    <li>
                        <a href="/#/contact" class="hover:text-blue-200">{{
                            $t("lang.Contact us")
                        }}</a>
                    </li>
                    <li>
                        <a href="/#/resource" class="hover:text-blue-200">{{
                            $t("lang.Resource")
                        }}</a>
                    </li>
                </ul>
            </div>

            <!-- Copyright -->
            <div
                class="mt-6 text-center text-xs md:text-sm text-gray-400 border-t border-gray-700 pt-4 pb-2"
            >
                &copy; {{ new Date().getFullYear() }} Design &amp; Developed by
                Degan Technologies PLC.
            </div>
        </div>
    </footer>
</template>
