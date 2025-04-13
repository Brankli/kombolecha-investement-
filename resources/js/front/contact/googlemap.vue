<template>
    <div class="flex justify-center font-roboto mb-16">
        <div class="w-full md:w-3/4 lg:w-2/3">
            <GoogleMap
                api-key="AIzaSyAKCGADXN5rafXDbsEO2764e-4j3XCwlJw"
                style="width: 100%; height: 500px"
                :center="center"
                :zoom="15"
            >
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
