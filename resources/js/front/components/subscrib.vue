<script setup>
import axios from "axios";
import { ref } from "vue";
import { useAlertsStore } from "../../store/useAlertsStore";

const alertStore = useAlertsStore();
const email = ref("");

const storesubscriber = () => {
  axios
    .post("./api/subscriber/store", { email: email.value })
    .then((res) => {
      alertStore.showSuccessToast(res.data.message);
      setTimeout(() => {
        email.value = "";
      }, 2000);
    })
    .catch((err) => {
      return alertStore.showErrortost(err.response.data.error);
    });
};
</script>

<template>
  <div class="w-full sm:w-16/12 md:w-6/12 px-5">
    <form class="flex flex-row" id="subscribeForm">
      <input
        class="border border-gray-300 rounded-md py-1 px-2 mr-2 focus:outline-none"
        type="email"
        placeholder="Enter your email"
        v-model="email"
        name="email"
        id="email"
        required
      />
      <button
        @click.prevent="storesubscriber"
        class="bg-blue-500 text-white text-lg font-bold px-5 py-1 border border-blue-700 rounded-md cursor-pointer"
        type="submit"
      >
        Subscribe
      </button>
    </form>
  </div>
</template>