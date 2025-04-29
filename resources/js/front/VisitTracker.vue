<template>
    <div></div>
</template>

<script setup>
import { onMounted, onUnmounted } from "vue";
import axios from "axios";
import { ref } from "vue";

const visitId = ref(null);
const visitStartTime = ref(null);

const startVisit = async () => {
    visitStartTime.value = new Date();

    try {
        const response = await axios.post("/api/visiters");
        visitId.value = response.data.visit_id;
    } catch (error) {}
};

const endVisit = async () => {
    if (!visitId.value || !visitStartTime.value) return;

    const duration = Math.floor((new Date() - visitStartTime.value) / 1000);

    try {
        await axios.put(`/api/visits/${visitId.value}`, {
            duration: duration,
        });
    } catch (error) {
        const blob = new Blob(
            [
                JSON.stringify({
                    visit_id: visitId.value,
                    duration: duration,
                }),
            ],
            { type: "application/json" }
        );
        navigator.sendBeacon(`/api/visits/${visitId.value}`, blob);
    }
};

onMounted(() => {
    startVisit();
});

onUnmounted(() => {
    endVisit();
});

const handleVisibilityChange = () => {
    if (document.visibilityState === "hidden") {
        endVisit();
    } else {
        startVisit();
    }
};

window.addEventListener("beforeunload", endVisit);
document.addEventListener("visibilitychange", handleVisibilityChange);
</script>
