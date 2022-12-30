<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { ArrowRightOnRectangleIcon } from '@heroicons/vue/24/outline';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="leading-normal tracking-normal text-gray-900">
        <div class="h-screen pb-14 bg-right bg-cover" style="background-image:url('/bg.svg');">
            <!--Nav-->
            <div class="w-full container mx-auto p-1 bg-gray-100">

                <div class="w-full flex items-center justify-between">
                    <a class="flex items-center text-gray-600 no-underline hover:no-underline font-bold text-2xl lg:text-xl"
                        href="/">
                        <img src="@/assets/logo.png" class="w-14 mr-4" />Waste Inspection
                    </a>

                    <div class="flex justify-center">
                        <Inertia-Link
                            class="inline-grid grid-flow-col text-indigo-600 no-underline hover:text-indigo-800 hover:text-underline text-center h-10 md:h-auto md:p-4 uppercase "
                            :class="{ 'font-bold': route().current('home') }" href="/">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            Нүүр хуудас
                        </Inertia-Link>
                        <Inertia-Link
                            class="inline-grid grid-flow-col text-indigo-600 no-underline hover:text-indigo-800 hover:text-underline text-center h-5 p-2 md:h-auto md:p-4 uppercase "
                            :class="{ 'font-bold': route().current('dashboard') }" :href="route('dashboard')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                            </svg>

                            Нээлттэй мэдээлэл
                        </Inertia-Link>
                    </div>
                    <div class="flex w-1/4 justify-end content-center">

                        <Inertia-Link
                            class="inline-grid grid-flow-col text-white no-underline hover:text-indigo-800 hover:text-underline text-center p-2 border rounded-lg bg-indigo-400"
                            href="/login">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>

                            НЭВТРЭХ
                        </Inertia-Link>
                    </div>

                </div>

            </div>
            <div class="container mx-auto">
                <slot />
            </div>
        </div>
    </div>
</template>
