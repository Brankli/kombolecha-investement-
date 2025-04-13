<script setup>
import { useI18n } from "vue-i18n";
const { t } = useI18n();

const cards = [
    {
        title: "lang.Comparativeadvantage",
        items: [
            "lang.cityadministration",
            "lang.manufacturingindustries",
            "lang.standardhotels",
            "lang.hospitalandhealth",
            "lang.manpower",
            "lang.peace",
        ],
    },
    {
        title: "lang.location",
        items: [
            "lang.Latitude",
            "lang.awayfrom",
            "lang.Semera-Logia",
            "lang.portofDjibouti",
            "lang.AsabPort",
        ],
    },
    {
        title: "lang.Infrastructuredata",
        items: [
            "lang.Awash-Kombolcha",
            "lang.Ko/Cha-Bati-Mile",
            "lang.Dryport",
            "lang.Airtransport",
            "lang.powerElectricity",
        ],
    },
    {
        title: "lang.naturalresources",
        items: [
            "lang.animalresources",
            "lang.factoryinput",
            "lang.climate",
            "lang.groundwaterresources",
            "lang.minerals",
            "lang.investment",
        ],
    },
];
</script>

<template>
    <div class="max-w-7xl mx-auto md:px-4 py-12">
        <!-- group for synchronized hover -->
        <div
            class="group grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2  gap-8 items-stretch">
            <div v-for="(card, idx) in cards" :key="idx"
                class="p-1 bg-gradient-to-r from-sky-500 to-sky-600 rounded-xl md:rounded-2xl h-full transform transition-all duration-300 border-2 border-sky-500">
                <div class="bg-white rounded-2xl p-4 md:p-8 flex flex-col justify-center items-center h-full">
                    <h2 class="text-2xl font-extrabold capitalize text-orange-400 mb-6">
                        {{ t(card.title) }}
                    </h2>
                    <ul class="space-y-2 flex-1">
                        <li v-for="(item, i) in card.items" :key="i" class="flex items-start gap-4">
                            <div class="p-2 flex items-center justify-center">
                                <i class="material-icons text-sky-500 text-xl">done</i>
                            </div>
                            <span class="text-lg text-gray-600 leading-relaxed">
                                {{ t(item) }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
