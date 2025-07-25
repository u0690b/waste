<script setup>
    import ApplicationLogo from '@/Components/ApplicationLogo.vue';
    import { ArrowRightOnRectangleIcon } from '@heroicons/vue/24/outline';
    import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="leading-normal tracking-normal text-gray-900">
        <div class="h-screen bg-right bg-cover pb-14" style="background-image:url('/bg.svg');">
            <!--Nav-->
            <div class="w-full p-1 bg-gray-100 ">
                <div class="container flex items-center justify-between w-full mx-auto">
                    <a class="flex items-center text-2xl font-bold text-gray-600 no-underline hover:no-underline lg:text-xl" :href="route('dashboard')">
                        <img src="../assets/logo.png" class="w-12 mr-4" />ХҮРЭЭЛЭН БУЙ ОРЧНЫ ОЛОН НИЙТИЙН ХЯНАЛТ
                    </a>

                    <!-- <div class="flex justify-center">
                        <ILink class="inline-grid h-5 grid-flow-col p-2 text-center text-indigo-600 no-underline uppercase hover:text-indigo-800 hover:text-underline md:h-auto md:p-4 " :class="{ 'font-bold': route().current('dashboard') }" :href="route('dashboard')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                            </svg>

                            Нээлттэй мэдээлэл
                        </ILink>
                    </div> -->
                    <div class="flex content-center justify-end w-1/4">

                        <ILink class="inline-grid grid-flow-col p-2 text-center text-white no-underline bg-indigo-400 border rounded-lg hover:text-indigo-800 hover:text-underline" href="/login">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>
                            НЭВТРЭХ
                        </ILink>
                    </div>

                </div>

            </div>
            <div class="container mx-auto">
                <slot />
            </div>
            <div class="w-full pt-5 pb-5 my-20 text-sm text-center bg-gray-100 md:text-center fade-in">
                Developed by Лансерс ХХК /Хуулбарлахыг хориглоно
                <a class="text-gray-500 no-underline hover:no-underline" href="#">&copy; {{ (new
                    Date()).getFullYear()
                }} он</a>
            </div>
        </div>
    </div>
</template>
