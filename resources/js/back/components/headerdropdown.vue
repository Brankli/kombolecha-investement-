<script setup>
import { useLocalStorage } from '@vueuse/core';
const token = useLocalStorage('token', '');
const emit = defineEmits(['closeEvent']);
const handleevent = () => {
  emit('closeEvent');
}
function logout() {
  token.value = '';
  localStorage.setItem('user', '');
  window.location.href = '/';
}
</script>
<template>
  <div @click.prevent="handleevent"
    class="absolute  right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
    role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
    <div class="py-1" role="none">
      <router-link to="/userprofile" class="text-gray-700 block hover:bg-gray-100 px-4 py-2 text-sm">profiles</router-link>
      <router-link to="/profile" class="text-gray-700 block hover:bg-gray-100 px-4 py-2 text-sm">Password reset
        settings</router-link>
      <button @click.prevent="logout()" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem"
        tabindex="-1" id="menu-item-2">Logout</button>
    </div>
  </div>
</template>