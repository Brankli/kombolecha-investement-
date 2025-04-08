<template>
    <div class="grid sm:grid-cols-3 font-roboto m-8 text-left">
        <div class="bg-white rounded-lg  border-gray-200 border-2 shadow">
            <h1 class="font-bold text-4xl p-8 text-center capitalize">{{ $t('lang.GetInTouch') }}</h1>
            <div class="flex flex-row p-4 gap-4 md:m-4">
                <i class="material-icons text-4xl p-4 bg-black rounded-full text-white">meeting_room</i>
                <div>
                    <h1 class="font-bold text-2xl capitalize">{{ $t('lang.MeetUs') }}</h1>
                    <p>Kombolcha, Ethiopia</p>
                </div>
            </div>
            <div class="flex flex-row p-4 gap-4 md:m-4">
                <i class="material-icons text-4xl p-4 bg-black rounded-full text-white">phone_in_talk</i>
                <div>
                    <h1 class="font-bold text-2xl capitalize">{{ $t('lang.CallUs') }}</h1>
                    <p>033-3519009/2933</p>
                </div>
            </div>
            <div class="flex flex-row p-4 gap-4 md:m-4">
                <i class="material-icons text-4xl p-4 bg-black rounded-full text-white">mail</i>
                <div>
                    <h1 class="font-bold text-2xl capitalize">{{ $t('lang.EmailUs') }}</h1>
                    <p>kochinvest12@gmail.com</p>
                </div>
            </div>
        </div>
        <div class="col-span-2">
            <GoogleMap api-key="AIzaSyAKCGADXN5rafXDbsEO2764e-4j3XCwlJw" style="width: 100%; height: 500px"
                :center="center" :zoom="15">
                <Marker :options="{ position: center }" />
            </GoogleMap>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import { GoogleMap, Marker } from "vue3-google-map";

export default defineComponent({
    components: { GoogleMap, Marker },
    setup() {
        const center = { lat: 11.07989628841707, lng: 39.741800149907704 };

        return { center };
    },
});
</script>