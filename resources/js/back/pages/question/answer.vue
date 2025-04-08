<script setup>
import name from "../../components/name.vue"
import axios from "axios"
import { onMounted, ref } from "vue";
import { useLocalStorage } from "@vueuse/core";
import { useRoute } from "vue-router";
import { useAlertsStore } from "../../../store/useAlertsStore";

const alertstore = useAlertsStore();
const route = useRoute();
const id = ref(route.params.id);
const answer = ref('');
const token = useLocalStorage('token', '');
const question = ref('');

onMounted(()=>{
    axios.defaults.headers.common['Authorization'] = token.value;
    axios.get(`./api/question/show/${id.value}`).then(res=>{
        question.value = res.data.question
    }).catch(error=>{
        console.log(error);
    })
})
const respondanswer = () => {
    axios.defaults.headers.common['Authorization'] = token.value;
    axios.post(`./api/answer/${id.value}`,{ answer: answer.value }).then(res => {
        alertstore.showSuccessToast(res.data.message);
        setTimeout(() => {
            answer.value = ''
        }, 2000);
    }).catch(err => {
        alertstore.showErrortost(err.response.data.error);
    })
}

</script>
<template>
    <name name="Answer By Email" />
    <div class="bg-gray-100 md:p-16 h-fit pt-16">
        <div class="border-2  bg-white border-gray-300 shadow-lg max-w-4xl mx-auto rounded shadow-gray-100">
            <div class="w-full  bg-white rounded-lg   md:mt-0 xl:p-0 ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-lg  text-sky-700 leading-tight tracking-wide capitalize"> <span class="font-bold">Question: </span>{{ question.question }} ?</h1>
                    <form class="mb-6">
                        <div class="mb-6">
                            <label for="title"
                                class="block mb-2 text-sm font-medium text-gray-900 capitalize">Answer</label>
                            <textarea id="title" v-model="answer" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                placeholder="this answer is riched tothe user by email"></textarea>
                        </div>
                        <button @click.prevent="respondanswer"
                            class="text-white bg-blue-700 capitalize hover:bg-blue-800 w-5xl focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 block">Send
                            Answer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

