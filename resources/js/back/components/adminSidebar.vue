<script setup>
import { ref } from "vue";

const emit = defineEmits(["closeEvent"]);
const showSidebar = ref(false);

const toggleSidebar = () => {
  showSidebar.value = !showSidebar.value;
  emit("closeEvent", showSidebar.value);
};

const props = defineProps({
  user: "",
});
</script>

<template>
  <div class="fixed md:relative bg-darkblue block min-h-screen w-fit">
    <div>
      <font-awesome-icon
        @click.prevent="toggleSidebar"
        class="material-icons text-white block md:hidden text-white-500 m-2 w-20 align-middle cursor-pointer"
        icon="menu"
      />
    </div>
    <div
      class="bg-darkblue text-cyan-100 w-72 space-y-6 px-4 py-4 relative inset-y-0 left-0 md:relative transform transition-transform duration-200 ease-out"
      :class="{
        'translate-x-0': showSidebar,
        '-translate-x-full': !showSidebar,
        'md:translate-x-0': true,
      }"
    >
      <div class="flex flex-row justify-between">
        <div class="flex flex-row gap-4 align-middle">
          <img
            v-if="props.user.image"
            class="w-10 h-10 rounded-full"
            :src="props.user.image"
            alt=""
          />
          <h1 class="font-bold my-auto text-lg align-middle uppercase tracking-wider">
            {{ props.user.name }}
          </h1>
        </div>
        <router-link to="/dashbord">
          <font-awesome-icon icon="settings" class="text-white text-2xl my-auto" />
        </router-link>
      </div>
      <hr />
      <nav>
        <router-link
          to="/dashbord"
          class="flex items-center space-x-2 py-3 px-4 group transition duration-200 hover:bg-cyan-700 rounded hover:text-cyan-300"
        >
          <font-awesome-icon icon="home" class="text-white" />
          <span class="text-xl font-semibold text-white px-2">Dashboard</span>
        </router-link>
        <router-link
          to="/newspage"
          class="flex items-center space-x-2 py-3 px-4 group transition duration-200 hover:bg-cyan-700 rounded hover:text-cyan-300"
        >
          <font-awesome-icon icon="newspaper" class="text-white" />
          <span class="text-xl font-semibold text-white px-2">news</span>
        </router-link>
        <router-link
          to="/content"
          class="flex items-center space-x-2 py-3 px-4 group transition duration-200 hover:bg-cyan-700 rounded hover:text-cyan-300"
        >
          <font-awesome-icon icon="tv" class="text-white" />
          <span class="text-xl font-semibold text-white px-2">Content</span></router-link
        >
        <router-link
          to="/ourwork"
          class="flex items-center space-x-2 py-3 px-4 group transition duration-200 hover:bg-cyan-700 rounded hover:text-cyan-300"
        >
          <font-awesome-icon icon="list-check" class="text-white" />
          <span class="text-xl font-semibold text-white px-2">Our Work</span></router-link
        >
        <router-link
          to="/services"
          class="flex items-center space-x-2 py-3 px-4 group transition duration-200 hover:bg-cyan-700 rounded hover:text-cyan-300"
        >
          <font-awesome-icon icon="chart-line" class="text-white" />
          <span class="text-xl font-semibold text-white px-2">services</span></router-link
        >
        <router-link
          to="/channels"
          class="flex items-center space-x-2 py-3 px-4 group transition duration-200 hover:bg-cyan-700 rounded hover:text-cyan-300"
        >
          <font-awesome-icon icon="file" class="text-white" />
          <span class="text-xl font-semibold text-white px-2">Channels</span></router-link
        >
        <router-link
          to="/sponsers"
          class="flex items-center space-x-2 py-3 px-4 group transition duration-200 hover:bg-cyan-700 rounded hover:text-cyan-300"
        >
          <font-awesome-icon icon="handshake" class="text-white" />
          <span class="text-xl font-semibold text-white px-2">Partners</span></router-link
        >
        <router-link
          to="/newtestimonial"
          class="flex items-center space-x-2 py-3 px-4 group transition duration-200 hover:bg-cyan-700 rounded hover:text-cyan-300"
        >
          <font-awesome-icon icon="comment" class="text-white" />
          <span class="text-xl font-semibold text-white px-2"
            >Testimonies</span
          ></router-link
        >
        <router-link
          to="/staff"
          class="flex items-center space-x-2 py-3 px-4 group transition duration-200 hover:bg-cyan-700 rounded hover:text-cyan-300"
        >
          <font-awesome-icon icon="paper-plane" class="text-white" />
          <span class="text-xl font-semibold text-white px-2">staff</span></router-link
        >
        <router-link
          to="/sliderindex"
          class="flex items-center space-x-2 py-3 px-4 group transition duration-200 hover:bg-cyan-700 rounded hover:text-cyan-300"
        >
          <font-awesome-icon icon="paper-plane" class="text-white" />
          <span class="text-xl font-semibold text-white px-2">slider</span></router-link
        >
      </nav>
    </div>
  </div>
</template>
