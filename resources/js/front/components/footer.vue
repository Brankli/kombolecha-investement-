<script setup>
import subscribe from './subscrib.vue';
import partner from "./partner.vue";
import testimonial from './testimonial.vue';
</script>
<template>
  <div>
    <testimonial />
    <partner />
  </div>
  <footer class="relative w-full font-roboto bottom-0 bg-cyan-950">
    <div class=" mx-auto  ">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
        <!-- Existing Content -->
        <div class="col">
          <!-- ... Existing content ... -->
          <ul class="flex flex-col list-none md:justify-end justify-center">
            <!-- New Footer Element -->
            <li>
              <a href="#" class="text-blue-400 hover:text-blue-200 text-xl font-extrabold block uppercase py-5 px-3">{{
                $t('lang.aboute us') }} </a>
            </li>
            <!-- ABOUT KOMBOLCHA INDUSTRY and INVESTMENT DEPARTMENT -->
            <router-link to="/aboutdeps">
              <div>
                <h3 class="text-white text-sm font-extrabold block py-3 uppercase px-3">{{ $t('lang.About KIID') }}</h3>
              </div>
              <li>
                <a class="text-gray-300 hover:text-white text-sm font-medium block py-1 px-3">{{ $t('lang.Overview')
                  }}</a>
              </li>
              <li>
                <a class="text-gray-300 hover:text-white text-sm font-medium block py-1 px-3">{{ $t('lang.Mission') }}
                </a>
              </li>
              <li>
                <a class="text-gray-300 hover:text-white text-sm font-medium block py-1 px-3">{{ $t('lang.Vision')
                  }}</a>
              </li>
            </router-link>
            <!-- ABOUT KOMBOLCHA CITY -->
            <router-link to="/Aboutekocha">
              <div>
                <h3 class="text-white text-sm font-extrabold block py-3 px-3 uppercase">{{ $t('lang.About KC') }}</h3>
              </div>
              <li>
                <a class="text-gray-300 hover:text-white text-sm font-medium block py-1 px-3">{{ $t('lang.history')
                  }}</a>
              </li>
              <li>
                <a class="text-gray-300 hover:text-white text-sm font-medium block py-1 px-3">{{ $t('lang.geolocation')
                  }} </a>
              </li>
              <li>
                <a class="text-gray-300 hover:text-white text-sm font-medium block py-1 px-3">{{ $t('lang.weather') }}
                </a>
              </li>
              <li>
                <a class="text-gray-300 hover:text-white text-sm font-medium block py-1 px-3">{{
                $t('lang.compAdvantage') }} </a>
              </li>
            </router-link>
          </ul>
        </div>
        <!-- OUR WORKS -->
        <div class="col">
          <router-link to="/getourwork">
            <ul class="flex flex-col list-none md:justify-end justify-center">
              <!--Our works Element -->
              <li>
                <a href="#" class="text-blue-400 hover:text-blue-200 text-lg font-extrabold block uppercase py-5 px-3">
                  {{ $t('lang.our works') }} </a>
              </li>
              <!-- Industrial Sectors -->
              <div>
                <h3 class="text-white text-sm font-extrabold block py-3 px-3 uppercase"> {{ $t('lang.Industrial sector')
                  }}</h3>
              </div>
              <li>
                <a href="#" class="text-gray-100 hover:text-white text-sm font-extrabold block py-2 px-3">{{
                $t('lang.agro process') }}</a>
              </li>
              <li>
                <a href="#" class="text-gray-300 hover:text-white text-sm font-medium block py-1 px-3">{{
                $t('lang.fabricate leather') }}</a>
              </li>
              <li>
                <a href="#" class="text-gray-100 hover:text-white text-sm font-extrabold block py-1 px-3">{{
                $t('lang.textile and cloth sec') }}</a>
              </li>
              <li>
                <a href="#" class="text-gray-100 hover:text-white text-sm font-extrabold block py-1 px-3">{{
                $t('lang.wood sec') }}</a>
              </li>
              <!-- Service Sectors element -->
              <div>
                <h3 class="text-white text-sm font-extrabold block py-3 px-3">{{ $t('lang.service sec') }}</h3>
              </div>
              <!-- Construction Sector -->
              <li>
                <a href="#" class="text-gray-100 hover:text-white text-sm font-extrabold block py-1 px-3">{{
                $t('lang.const sec') }}</a>
              </li>
              <!-- Social Sectors -->
              <li>
                <a href="#" class="text-gray-100 hover:text-white text-sm font-extrabold block py-1 px-3">{{
                $t('lang.social sector') }} </a>
              </li>
            </ul>
          </router-link>
        </div>

        <!-- DEPARTMENTS -->

        <div class="col">
          <ul class="flex flex-col list-none md:justify-end justify-center">
            <!-- Departments  Element -->
            <li>
              <a href="#" class="text-blue-400 hover:text-blue-200 text-lg font-extrabold uppercase block py-5 px-3">{{
                $t('lang.Departments') }}
              </a>
            </li>
            <li>
              <router-link to="/expansion"
                class="text-gray-100 hover:text-white text-sm font-extrabold block py-1 px-3"> {{
                $t('lang.expInvestment') }}</router-link>
            </li>
            <li>
              <router-link to="/development"
                class="text-gray-100 hover:text-white text-sm font-extrabold block py-1 px-3"> {{ $t('lang.industrydev')
                }}</router-link>
            </li>
            <li>
              <router-link to="/minirals" class="text-gray-100 hover:text-white text-sm font-extrabold block py-1 px-3">
                {{ $t('lang.mining opma') }}</router-link>
            </li>
          </ul>
          <div class="flex flex-col items-start md:justify-between justify-center py-5 px-1">
            <div class="w-full md:w-11/12 px-1 py-5">
              <h2 class="text-white text-xl font-bold px-1 py-1">{{ $t('lang.join us') }}</h2>
              <p class="text-white text-lg font-medium px-1 py-2">{{ $t('lang.email and subscribe') }}</p>
            </div>
            <subscribe />
          </div>
        </div>
      </div>
      <div class="flex flex-col items-end bg-cyan-950  md:justify-between justify-end py-1 ">
        <div class="w-full md:w-4/12  px-4">
          <h2 class="text-white text-sm font-bold px-18 py-3 ">{{ $t('lang.follow us') }} :</h2>
        </div>
        <div class="w-full bg-cyan-950 px-4">
          <!-- Update your social media links -->
          <ul class="flex flex-wrap list-none md:justify-end justify-center">
            <li>
              <a href="https://t.me/kombolchaindustryandinvestment"
                class="text-white hover:text-gray-400  text-sm font-semibold  py-1 px-3">
                <i class="fab fa-telegram"></i> {{ $t('lang.Telegram') }}
              </a>
            </li>
            <li>
              <a href="https://www.facebook.com/p/Kombolcha-industry-and-investment-department-100080887707066/"
                class="text-white hover:text-gray-400 text-sm font-semibold  py-1 px-3">
                <i class="fab fa-facebook"></i> {{ $t('lang.Facebook') }}
              </a>
            </li>
            <li>
              <a href="https://www.youtube.com/@kombolchacityindustryandin1377"
                class="text-white hover:text-gray-400 text-sm font-semibold  py-1 px-3">
                <i class="fab fa-youtube"></i> {{ $t('lang.Youtube') }}
              </a>
            </li>
            <li>
              <a href="https://www.facebook.com/p/Kombolcha-industry-and-investment-department-100080887707066/"
                class="text-white hover:text-gray-400 text-sm font-semibold  py-1 px-3">
                <i class="fab fa-twitter"></i> {{ $t('lang.Twitter') }}
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="flex flex-wrap items-center md:justify-between w-full bg-cyan-950 justify-center">
        <div class="w-full md:w-4/12 px-4">
          <div class="text-sm text-white font-semibold py-1">
            Copyright ©
            <a href="#" class="text-white hover:text-gray-400 text-sm font-semibold py-1">design & developed by Degan Technologies Plc</a>
          </div>
        </div>
        <div class="w-full md:w-8/12 px-4">
          <ul class="flex flex-wrap list-none md:justify-end  justify-center">
            <li>
              <a href="#" class="text-white hover:text-gray-400 text-sm font-semibold block py-1 px-3">{{
                $t('lang.News') }}</a>
            </li>
            <li>
              <a href="/#/contact" class="text-white hover:text-gray-400 text-sm font-semibold block py-1 px-3">{{
                $t('lang.Contact us') }}</a>
            </li>
            <li>
              <a href="/#/resource" class="text-white hover:text-gray-400 text-sm font-semibold block py-1 px-3">{{
                $t('lang.Resource') }}</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</template>

