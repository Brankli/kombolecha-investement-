<script setup>
import departments from '../dropdowns/departments.vue';
import { ref } from 'vue';

const className = ref('hidden');
const depClass = ref('hidden');

const togglemenu = () => {
  className.value = className.value === 'hidden' ? 'unhidden' : 'hidden';
};

const departmenttogle = () => {
  depClass.value = depClass.value === 'hidden' ? 'unhidden' : 'hidden';
};
</script>

<template>
  <div class="rounded w-full mx-auto bg-briteblue">
    <nav class="mb-2 w-fit mx-auto my-auto">
      <div class="text-lg flex flex-row mt-2 text-green-100 gap-8 justify-between font-bold">
        <div class="lg:hidden cursor-pointer" @click.prevent="togglemenu">
          <i class="material-icons align-middle ml-4 text-white">menu</i>
        </div>
        <div class="lg:flex lg:flex-row w-full" :class="className">
          <!-- Nav Item Template -->
          <div
            class="border-b-2 lg:border-b-0 p-2 transition-colors duration-300 ease-in-out border-white hover:text-yellow-300"
            @click="depClass = 'hidden'"
          >
            <a class="px-4 border-b-4 border-transparent hover:border-yellow-300" href="#">
              <span>{{ $t('lang.Home') }}</span>
            </a>
          </div>

          <!-- Departments Dropdown -->
          <div
            class="border-b-2 lg:border-b-0 p-2 transition-colors duration-300 ease-in-out border-white hover:text-yellow-300"
          >
            <a class="px-4 hover:border-b-4 border-transparent hover:border-yellow-300 cursor-pointer" href="#" @click.prevent="departmenttogle">
              <span>{{ $t('lang.Departments') }}</span>
            </a>
            <departments :class="depClass" @some-event="departmenttogle" />
          </div>

          <!-- About Us -->
          <div
            class="border-b-2 lg:border-b-0 p-2 transition-colors duration-300 ease-in-out border-white hover:text-yellow-300"
            @click="depClass = 'hidden'"
          >
            <router-link class="px-4 hover:border-b-4 border-transparent hover:border-yellow-300" to="/aboutdeps">
              <span>{{ $t('lang.aboute us') }}</span>
            </router-link>
          </div>

          <!-- Kocha -->
          <div
            class="border-b-2 lg:border-b-0 p-2 transition-colors duration-300 ease-in-out border-white hover:text-yellow-300"
            @click="depClass = 'hidden'"
          >
            <router-link class="px-4 hover:border-b-4 border-transparent hover:border-yellow-300" to="/Aboutekocha">
              <span>{{ $t('lang.kocha') }}</span>
            </router-link>
          </div>

          <!-- Our Works -->
          <div
            class="border-b-2 lg:border-b-0 p-2 transition-colors duration-300 ease-in-out border-white hover:text-yellow-300"
            @click="depClass = 'hidden'"
          >
            <router-link class="px-4 hover:border-b-4 border-transparent hover:border-yellow-300" to="/getourwork">
              <span>{{ $t('lang.our works') }}</span>
            </router-link>
          </div>

          <!-- Contact Us -->
          <div
            class="border-b-2 lg:border-b-0 p-2 transition-colors duration-300 ease-in-out border-white hover:text-yellow-300"
            @click="depClass = 'hidden'"
          >
            <router-link class="px-4 hover:border-b-4 border-transparent hover:border-yellow-300" to="/contact">
              <span>{{ $t('lang.Contact us') }}</span>
            </router-link>
          </div>

          <!-- Resource -->
          <div
            class="border-b-2 lg:border-b-0 p-2 transition-colors duration-300 ease-in-out border-white hover:text-yellow-300"
            @click="depClass = 'hidden'"
          >
            <router-link class="px-4 hover:border-b-4 border-transparent hover:border-yellow-300" to="/resource">
              <span>{{ $t('lang.Resource') }}</span>
            </router-link>
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>
