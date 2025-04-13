<script setup>
import axios from "axios";
import { ref } from "vue";
import { useAlertsStore } from "../../store/useAlertsStore";

const alert = useAlertsStore();
const question = ref("");
const email = ref("");
const phone_no = ref("");

const formData = new FormData();

const ask = () => {
    formData.append("question", question.value);
    formData.append("email", email.value);
    formData.append("phone_no", phone_no.value);
    axios
        .post("./api/question/store", formData)
        .then((res) => {
            alert.showSuccessToast(res.data.message);
            setTimeout(() => {
                email.value = "";
                phone_no.value = "";
                question.value = "";
            }, 2000);
        })
        .catch((res) => {
            alert.showErrortost(res.response.data.error);
        });
};
</script>

<template>
    <div class="">
        <div class="w-full md:mt-0 xl:p-0">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1
                    class="text-lg font-bold text-sky-700 leading-tight tracking-wide"
                >
                    {{ $t("lang.QuestionService") }}
                </h1>

                <form class="mb-6">
                    <div class="mb-6">
                        <label
                            for="email"
                            class="block mb-2 text-sm font-medium capitalize text-gray-900"
                            >{{ $t("lang.E-mail") }}</label
                        >
                        <input
                            v-model="email"
                            type="email"
                            id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none"
                            placeholder="Enter Your Email"
                            required
                        />
                    </div>
                    <div class="mb-6">
                        <label
                            for="phone"
                            class="block mb-2 text-sm font-medium text-gray-900"
                            >{{ $t("lang.Phonenumber") }}</label
                        >
                        <input
                            v-model="phone_no"
                            type="text"
                            id="phone"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 outline-none"
                            placeholder="Enter Your Phone"
                            required
                        />
                    </div>
                    <div class="mb-6">
                        <label
                            for="message"
                            class="block mb-2 text-sm font-medium text-gray-900"
                            >{{ $t("lang.Question") }}</label
                        >
                        <textarea
                            v-model="question"
                            id="message"
                            rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
                            placeholder="Your question..."
                            required
                        ></textarea>
                    </div>
                    <button
                        @click.prevent="ask"
                        class="text-white bg-blue-700 hover:bg-blue-800 w-full focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 block"
                    >
                        {{ $t("lang.Sendquestion") }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
