<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { ArrowRightOnRectangleIcon } from '@heroicons/vue/24/outline';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="leading-normal tracking-normal text-gray-900">
        <div class=" bg-right bg-cover pb-14 bg-[#f7f2ee]">
            <!--Nav-->
            <div class="mx-auto container py-2 px-4 sm:rounded-2xl sm:mt-6 bg-[#dde9aa] mb-8">
                <div class="container flex items-center justify-between w-full mx-auto">
                    <a class="flex items-center text-xs font-bold text-gray-600 no-underline sm:text-2xl hover:no-underline lg:text-xl"
                        href="/">
                        <img src="../assets/icon-512.png" class="w-12 mr-4" />ХҮРЭЭЛЭН БУЙ ОРЧНЫ ОЛОН НИЙТИЙН ХЯНАЛТ
                    </a>


                    <div class="flex content-center justify-end ">

                        <ILink
                            class="inline-grid grid-flow-col p-2 text-center text-white no-underline bg-[#406f47]  hover:border border-[#406f47] rounded-lg hover:font-extrabold hover:shadow-lg hover:shadow-[#406f47]"
                            :href="route('login')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>
                            НЭВТРЭХ
                        </ILink>
                    </div>

                </div>

            </div>
            <div class="container mx-auto">
                <slot />
            </div>
            <div class="w-full pt-5 pb-5 my-20 text-sm text-center bg-[#dde9aa] md:text-center fade-in">
                Developed by Лансерс ХХК /Хуулбарлахыг хориглоно
                <a class="text-gray-500 no-underline hover:no-underline" href="#">&copy; {{ (new
                    Date()).getFullYear()
                }} он</a>
            </div>
        </div>
    </div>
</template>
