<template>
    <div class="hidden sm:block">
        <div class="text-sky-700">
            <div class="font-bold text-xl text-darkred p-4 border-b-2 border-gray-300">
                <h1>{{ $t('lang.Departments') }} </h1>
            </div>
            <div class="text-sky-700 flex flex-row mt-3 hover:bg-gray-100 hover:border-l-4 ml-4 hover:border-l-darkred">
                <router-link to="/expansion" class="border-b-2 w-full border-gray-200">
                    <p class="pl-4 text-md">{{ $t('lang.expInvestment') }}</p>
                </router-link>
            </div>
            <div class="text-sky-700 flex flex-row mt-3 hover:bg-gray-100 hover:border-l-4 ml-4 hover:border-l-darkred">
                <router-link to="/development" class="border-b-2 w-full border-gray-200">
                    <p class="pl-4 text-md ">{{ $t('lang.industrydev') }}</p>
                </router-link>
            </div>
            <div class="text-sky-700 flex flex-row mt-3 hover:bg-gray-100 hover:border-l-4 ml-4 hover:border-l-darkred">
                <router-link to="/minirals" class="border-b-2 w-full border-gray-200">
                    <p class="pl-4 text-md ">{{ $t('lang.mining opma') }}</p>
                </router-link>
            </div>
        </div>
        <div>
            <div class="font-bold text-xl text-darkred p-4 border-b-2 border-gray-300">
                <h1>{{ $t('lang.Sector') }} </h1>
            </div>
            <div class="text-sky-700 flex flex-row mt-3 hover:bg-gray-100 hover:border-l-4 ml-4 hover:border-l-darkred">
                <router-link to="/ourwork" class="border-b-2 w-full border-gray-200">
                    <p class="pl-4 text-md capitalize">{{ $t('lang.Industrial sector') }}</p>
                </router-link>
            </div>
            <div class="text-sky-700 flex flex-row mt-3 hover:bg-gray-100 hover:border-l-4 ml-4 hover:border-l-darkred">
                <router-link to="/ourwork" class="border-b-2 w-full border-gray-200">
                    <p class="pl-4 text-md  capitalize">{{ $t('lang.service sec') }}</p>
                </router-link>
            </div>
        </div>
        <div>
            <div class="font-bold text-xl text-darkred p-4 border-b-2 border-gray-300">
                <h1>{{ $t('lang.Partnerships') }} </h1>
            </div>
            <div class="text-sky-700 flex flex-row mt-3 hover:bg-gray-100 hover:border-l-4 ml-4 hover:border-l-darkred">
                <router-link to="/contact" class="border-b-2 w-full border-gray-200">
                    <p class="pl-4 text-md ">{{ $t('lang.Contact us') }}</p>
                </router-link>
            </div>
            <div class="text-sky-700 flex flex-row mt-3 hover:bg-gray-100 hover:border-l-4 ml-4 hover:border-l-darkred">
                <router-link to="/resource" class="border-b-2 w-full border-gray-200">
                    <p class="pl-4 text-md">{{ $t('lang.Resource') }}</p>
                </router-link>
            </div>
        </div>
    </div>
</template>