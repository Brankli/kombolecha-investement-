<script setup>
import contactform from "./contactus.vue";
import googlemap from "./googlemap.vue";
</script>

<template>
    <div
        class="grid grid-cols-1 md:grid-cols-2 gap-10 px-6 md:px-16 mt-16 font-sans"
    >
        <!-- Left Column: Text + Contact Info -->
        <div class="flex flex-col justify-center space-y-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-sky-600 mb-4">
                    {{ $t("lang.HwYou") }}
                </h1>
                <p class="text-gray-600 text-base leading-relaxed">
                    {{ $t("lang.AskQuestion") }}
                </p>
            </div>

            <div class="space-y-6 mt-4">
                <h2 class="text-3xl font-semibold text-gray-800">
                    {{ $t("lang.GetInTouch") }}
                </h2>

                <div class="flex items-start gap-4">
                    <i
                        class="fas fa-map-marker-alt text-3xl md:text-4xl text-orange-400 pt-1"
                    ></i>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">
                            {{ $t("lang.MeetUs") }}
                        </h3>
                        <p class="text-gray-600">Kombolcha, Ethiopia</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <i
                        class="fas fa-phone-volume text-3xl md:text-4xl text-orange-400 pt-1"
                    ></i>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">
                            {{ $t("lang.CallUs") }}
                        </h3>
                        <p class="text-gray-600">033-3519009 / 2933</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <i
                        class="fas fa-envelope text-3xl text-orange-400 pt-1"
                    ></i>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">
                            {{ $t("lang.EmailUs") }}
                        </h3>
                        <p class="text-gray-600">kochinvest12@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Contact Form -->
        <div class="bg-white shadow-lg p-6 md:p-10 rounded-xl">
            <contactform />
        </div>
    </div>

    <!-- Google Map -->
    <div class="w-full mt-16">
        <googlemap />
    </div>
</template>
