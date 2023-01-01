<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { ArrowRightOnRectangleIcon } from '@heroicons/vue/24/outline';
import { Head, Link } from '@inertiajs/inertia-vue3';

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
});
</script>

<template>

  <Head title="ХОГ ХАЯГДЛЫН ОЛОН НИЙТИЙН БАЙЦААГЧИЙН ХЯНАЛТ, УДИРДЛАГА, МЭДЭЭЛЛИЙН НЭГДСЭН СИСТЕМ" />


  <GuestLayout>
    <div class=" pt-24 md:pt-48 px-6 mx-auto flex flex-wrap flex-col md:flex-row items-center">


      <!--Left Col-->
      <div class="flex flex-col w-full xl:w-2/5 justify-center lg:items-start overflow-y-hidden">
        <h1
          class="my-4 text-3xl md:text-5xl text-purple-800 font-bold leading-tight text-center md:text-left slide-in-bottom-h1">
          ХОГ ХАЯГДЛЫН ОЛОН НИЙТИЙН </h1>
        <p class="leading-normal text-base md:text-2xl mb-8 text-center md:text-left slide-in-bottom-subtitle">
          БАЙЦААГЧИЙН ХЯНАЛТ, УДИРДЛАГА, МЭДЭЭЛЛИЙН НЭГДСЭН БҮРТГЭЛ</p>
      </div>

      <!--Right Col-->
      <div class="w-full xl:w-3/5 py-6 overflow-y-hidden">
        <!-- <img class="w-5/6 mx-auto lg:mr-0 slide-in-bottom" src="@/assets/devices.svg"> -->
        <div class="p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="about" role="tabpanel"
          aria-labelledby="about-tab">
          <h2 class="mb-5 text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white slide-in-bottom"> Зорилго
            хүрэх үр дүн:
          </h2>
          <!-- List -->
          <ul role="list" class="space-y-4 text-gray-500 dark:text-gray-400">
            <li class="flex space-x-2">
              <!-- Icon -->
              <svg class="flex-shrink-0 w-4 h-4 text-blue-600 dark:text-blue-500 slide-in-bottom" fill="currentColor"
                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span class="font-light leading-tight slide-in-bottom">Хог хаягдлын олон нийтийн байцаагч /ОНБ/-ийн
                зөрчлийн тэмдэглэл
                хөтлөх үйлдэл цахимжин хялбар болж, зөрчлийн
                мэдээллийн цахим сан бий болно</span>
            </li>
            <li class="flex space-x-2">
              <!-- Icon -->
              <svg class="flex-shrink-0 w-4 h-4 text-blue-600 dark:text-blue-500 slide-in-bottom" fill="currentColor"
                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span class="font-light leading-tight slide-in-bottom">Аливаа зөрчлийн мэдээллийг хариуцсан эрх бүхий
                байгууллага, албан
                тушаалтанд шуурхай хүргэн, шийдвэрлүүлнэ</span>
            </li>
            <li class="flex space-x-2">
              <!-- Icon -->
              <svg class="flex-shrink-0 w-4 h-4 text-blue-600 dark:text-blue-500 slide-in-bottom" fill="currentColor"
                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span class="font-light leading-tight slide-in-bottom">Зөрчил үүсгэж байгаа иргэн, аж ахуй нэгж,
                байгууллагын нэрс,
                зөрчлийн мэдээлэл, зөрчлийн шийдвэрлэлтийн явц,
                үр дүн олон нийтэд нээлттэй ил тод болно</span>
            </li>
            <li class="flex space-x-2">
              <!-- Icon -->
              <svg class="flex-shrink-0 w-4 h-4 text-blue-600 dark:text-blue-500 slide-in-bottom" fill="currentColor"
                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span class="font-light leading-tight slide-in-bottom">Нийслэл, дүүргийн асуудал хариуцсан холбогдох нэгж,
                хэлтсүүд хот,
                дүүргийн хэмжээнд гарч байгаа зөрчлийн тоо
                хэмжээ, төрөл, түүний шийдвэрлэлтийг тухай бүр хянах, шаардлагатай тайланг гаргах, дээд шатны удирдлагыг
                мэдээллээр шуурхай хангана</span>
            </li>
            <li class="flex space-x-2">
              <!-- Icon -->
              <svg class="flex-shrink-0 w-4 h-4 text-blue-600 dark:text-blue-500 slide-in-bottom" fill="currentColor"
                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span class="font-light leading-tight slide-in-bottom">Монгол Улсын Үндсэн хуульд заасан иргэний эрүүл,
                аюулгүй орчинд
                амьдрах нөхцөл бүрдэнэ</span>
            </li>
          </ul>
        </div>

      </div>
      <a href="http://www.ubservice.mn/?fbclid=IwAR0DRdfuer1AfiIURNjUTtXk4-XIjHP3H2dRBMwLw-dcMwQ1WA11mxS0fMc"
        target="_blank"><img src="../../../public/img/zaa1.jpg"
          class="object-contain w-48 ... px-4 slide-in-bottom" /></a>
      <a href="http://inspection.gov.mn/new/" target="_blank"><img src="../../../public/img/mergejil.jpg"
          class="object-contain w-48 ... slide-in-bottom" /></a>
      <a href="https://www.eda.admin.ch/countries/mongolia/mn/home/chegzhlijn.html" target="_blank"><img
          src="../../../public/img/sha.png" class="object-contain w-48 ... px-4 slide-in-bottom" /></a>

      <!--Footer-->
      <div class="w-full pt-5 pb-5 my-20 text-sm text-center md:text-left fade-in bg-gray-100">
        Developed by Лансерс ХХК /Хуулбарлахыг хориглоно
        <a class="text-gray-500 no-underline hover:no-underline" href="#">&copy; {{ (new
    Date()).getFullYear()
          }} он</a>
      </div>
    </div>
  </GuestLayout>


</template>
	<!-- Animation CSS-->
<style>
/* ----------------------------------------------
		 * Generated by Animista
		 * w: http://animista.net, t: @cssanimista
		 * ---------------------------------------------- */

.slide-in-bottom {
  -webkit-animation: slide-in-bottom .5s cubic-bezier(.25, .46, .45, .94) both;
  animation: slide-in-bottom .5s cubic-bezier(.25, .46, .45, .94) both
}

.slide-in-bottom-h1 {
  -webkit-animation: slide-in-bottom .5s cubic-bezier(.25, .46, .45, .94) .5s both;
  animation: slide-in-bottom .5s cubic-bezier(.25, .46, .45, .94) .5s both
}

.slide-in-bottom-subtitle {
  -webkit-animation: slide-in-bottom .5s cubic-bezier(.25, .46, .45, .94) .75s both;
  animation: slide-in-bottom .5s cubic-bezier(.25, .46, .45, .94) .75s both
}

.fade-in {
  -webkit-animation: fade-in 1.2s cubic-bezier(.39, .575, .565, 1.000) 1s both;
  animation: fade-in 1.2s cubic-bezier(.39, .575, .565, 1.000) 1s both
}

.bounce-top-icons {
  -webkit-animation: bounce-top .9s 1s both;
  animation: bounce-top .9s 1s both
}

@-webkit-keyframes slide-in-bottom {
  0% {
    -webkit-transform: translateY(1000px);
    transform: translateY(1000px);
    opacity: 0
  }

  100% {
    -webkit-transform: translateY(0);
    transform: translateY(0);
    opacity: 1
  }
}

@keyframes slide-in-bottom {
  0% {
    -webkit-transform: translateY(1000px);
    transform: translateY(1000px);
    opacity: 0
  }

  100% {
    -webkit-transform: translateY(0);
    transform: translateY(0);
    opacity: 1
  }
}

@-webkit-keyframes bounce-top {
  0% {
    -webkit-transform: translateY(-45px);
    transform: translateY(-45px);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in;
    opacity: 1
  }

  24% {
    opacity: 1
  }

  40% {
    -webkit-transform: translateY(-24px);
    transform: translateY(-24px);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in
  }

  65% {
    -webkit-transform: translateY(-12px);
    transform: translateY(-12px);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in
  }

  82% {
    -webkit-transform: translateY(-6px);
    transform: translateY(-6px);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in
  }

  93% {
    -webkit-transform: translateY(-4px);
    transform: translateY(-4px);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in
  }

  25%,
  55%,
  75%,
  87% {
    -webkit-transform: translateY(0);
    transform: translateY(0);
    -webkit-animation-timing-function: ease-out;
    animation-timing-function: ease-out
  }

  100% {
    -webkit-transform: translateY(0);
    transform: translateY(0);
    -webkit-animation-timing-function: ease-out;
    animation-timing-function: ease-out;
    opacity: 1
  }
}

@keyframes bounce-top {
  0% {
    -webkit-transform: translateY(-45px);
    transform: translateY(-45px);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in;
    opacity: 1
  }

  24% {
    opacity: 1
  }

  40% {
    -webkit-transform: translateY(-24px);
    transform: translateY(-24px);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in
  }

  65% {
    -webkit-transform: translateY(-12px);
    transform: translateY(-12px);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in
  }

  82% {
    -webkit-transform: translateY(-6px);
    transform: translateY(-6px);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in
  }

  93% {
    -webkit-transform: translateY(-4px);
    transform: translateY(-4px);
    -webkit-animation-timing-function: ease-in;
    animation-timing-function: ease-in
  }

  25%,
  55%,
  75%,
  87% {
    -webkit-transform: translateY(0);
    transform: translateY(0);
    -webkit-animation-timing-function: ease-out;
    animation-timing-function: ease-out
  }

  100% {
    -webkit-transform: translateY(0);
    transform: translateY(0);
    -webkit-animation-timing-function: ease-out;
    animation-timing-function: ease-out;
    opacity: 1
  }
}

@-webkit-keyframes fade-in {
  0% {
    opacity: 0
  }

  100% {
    opacity: 1
  }
}

@keyframes fade-in {
  0% {
    opacity: 0
  }

  100% {
    opacity: 1
  }
}
</style>