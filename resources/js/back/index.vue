<script setup>
import name from "./components/name.vue"
import { format, parseISO } from 'date-fns';
import questionDisplay from "./pages/question/question.vue"
import axios from "axios";
import { onMounted, ref, computed } from "vue";
import { useLocalStorage } from "@vueuse/core";

const token = useLocalStorage('token', '');
const allquestions = ref([]);
const readQuestion = ref(null);
const className = ref('')
const keywords = ref('');
const perPage = ref(5);
const currentPage = ref(1);
const allvisitor = ref([]);
const allsubscribers = ref('');
const countallquestions = ref('');



onMounted(async () => {
  axios.defaults.headers.common['Authorization'] = token.value;
  await axios.get('./api/getall/question').then(res => {
    allquestions.value = res.data;
  }).catch(err => console.log(err));
  await axios.get('./api/count/question').then(res => {
    countallquestions.value = res.data;
  }).catch(err => console.log(err));
  await axios.get('./api/countvisitor').then(res => {
    allvisitor.value = res.data;
  }).catch(err => console.log(err));
  await axios.get('./api/subscriber/getall').then(res => {
    allsubscribers.value = res.data.subscribers;
  }).catch(err => console.log(err));

});

function viewquestion(id) {
  className.value = 'unhide';
  const newid = id
  readQuestion.value = allquestions.value.find(question => question.id === newid);
}

const toggleQuestion = () => {
  if (className.value == 'hidden') {
    className.value = 'unhidden'
  } else {
    className.value = 'hidden'
  }
}

const searching = computed(() => {
  const keyword = keywords.value.toLocaleLowerCase();
  return allquestions.value.filter(item => item.question.toLowerCase().includes(keyword));
});


const paginatedData = computed(() => {
  const start = (currentPage.value - 1) * perPage.value;
  const end = start + perPage.value;
  return searching.value.slice(start, end);
});

const totalPages = computed(() => Math.ceil(searching.value.length / perPage.value));
const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

const formatDate = (isoDateString) => {
  const date = parseISO(isoDateString);
  return format(date, 'yyyy-MM-dd');
};

</script>

<template>
  <div class="bg-gray-100 mb-24">
    <name name="Dashbord" />
    <div class="grid sm:grid-cols-2 md:grid-cols-3  gap-4 sm:m-8 ">
      <!-- visitor card -->
      <div
        class="w-full shadow bg-white flex flex-row justify-between font-roboto shadow-blue-200 font-bold border-gray-200 m-4 text-left align-middle border-2 rounded-md">
        <div>
          <h1 class=" text-xl text-gray-400 font-normal p-4 pb-2">Total Visitor</h1>
          <h1 class="text-3xl text-sky-800 pl-4 pb-4">{{ allvisitor[0] }}</h1>
        </div>
        <i class="material-icons text-sky-700 text-2xl bg-sky-200 p-2 w-fit h-fit my-auto mx-auto rounded-md">group</i>
      </div>

      <!-- subscribers card -->
      <div
        class="w-full shadow bg-white flex flex-row justify-between font-roboto shadow-blue-200 font-bold border-gray-200 m-4 text-left align-middle border-2 rounded-md">
        <div>
          <h1 class=" text-xl text-gray-400 font-normal p-4 pb-2">Total Subscriber</h1>
          <h1 class="text-3xl text-sky-800 pl-4 pb-4">{{ allsubscribers }}</h1>
        </div>
        <i class="material-icons text-sky-700 text-2xl bg-sky-200 p-2 w-fit h-fit my-auto mx-auto rounded-md">group</i>
      </div>

      <!-- ansewerd questions -->
      <div
        class="w-full shadow bg-white flex flex-row justify-between font-roboto shadow-blue-200 font-bold border-gray-200 m-4 text-left align-middle border-2 rounded-md">
        <div>
          <h1 class=" text-xl text-gray-400 font-normal p-4 pb-2">Total Question</h1>
          <h1 class="text-3xl text-sky-800 pl-4 pb-4">{{ countallquestions }}</h1>
        </div>
        <i class="material-icons text-sky-700 text-2xl bg-sky-200 p-2 w-fit h-fit my-auto mx-auto rounded-md">group</i>
      </div>


    </div>
    <div class="m-4 rounded">
      <div class="w-full bg-white border-b-2 rounded border-gray-200 flex flex-row justify-between">
        <h1 class="font-bold text-gray-500 text-lg p-4 capitalize">Question table</h1>
      </div>

      <!-- table start here -->
      <div class="flex bg-white flex-col items-center justify-center">
        <div class=" w-full  relative p-2 overflow-x-auto shadow-md sm:rounded-lg xs:p-5">
          <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
            <div>
            </div>
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
              <div
                class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                <i class="fa-solid fa-magnifying-glass"></i>
              </div>
              <input v-model="keywords" @input="searching" type="text" id="table-search"
                class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-sky-500 focus:border-sky-500 outline-none"
                placeholder="Search for items">
            </div>
          </div>
          <questionDisplay @click.prevent="toggleQuestion" v-if="readQuestion" :class="className"
            :question="readQuestion.question" />
          <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
              <tr>
                <th scope="col" class="p-4">
                  view
                </th>
                <th scope="col" class="px-6 py-3">
                  question
                </th>
                <th scope="col" class="px-6 py-3">
                  email
                </th>
                <th scope="col" class="px-6 py-3">
                  phone number
                </th>
                <th scope="col" class="px-6 py-3">
                  date
                </th>
                <th scope="col" class="px-6 py-3">
                  answered
                </th>
              </tr>
            </thead>
            <tbody v-for="qestion in paginatedData" :key="qestion.id">
              <tr class="bg-white border-b hover:bg-gray-50">
                <td class="w-4 p-4">
                  <i @click="viewquestion(qestion.id)" class="material-icons text-green-700">visibility_off</i>
                </td>
                <th scope="row" class="px-6  py-4 font-medium text-gray-900 whitespace-nowrap">
                  {{ qestion.question.slice(0, 30) }}
                </th>
                <td class="px-6 py-4">
                  {{ qestion.email.slice(0, 15) }}
                </td>
                <td class="px-6 py-4">
                  {{ qestion.phone_no.slice(0, 15) }}
                </td>
                <td class="px-6 py-4">
                  {{ formatDate(qestion.created_at) }}
                </td>
                <td class="px-6 py-4">
                  <i v-if="qestion.is_answered == 'yes'" class="material-icons text-primary">mark_email_read</i>
                  <router-link :to="{ name: 'answer', params: { id: qestion.id } }"> <i
                      v-if="qestion.is_answered == 'no'"
                      class="material-icons text-green-700">unsubscribe</i></router-link>
                </td>
              </tr>
            </tbody>

          </table>
          <div v-if="perPage >= 5" class="w-full justify-center gap-2 flex flex-row pt-4">
            <div><button
                class="shadow p-2 bg-gray-200 active:text-red-500 hover:bg-gray-300 text-briteblue text-lg font-bold rounded"
                @click="prevPage" :disabled="currentPage === 1">Back</button></div>
            <div><button class="shadow p-2 bg-gray-200 text-briteblue hover:bg-gray-300 text-lg font-bold rounded">page
                {{
            currentPage
          }}</button></div>
            <div><button
                class="shadow p-2 bg-gray-200 active:text-red-500 text-briteblue hover:bg-gray-300 text-lg font-bold rounded"
                @click="nextPage" :disabled="currentPage === totalPages">Next</button></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>