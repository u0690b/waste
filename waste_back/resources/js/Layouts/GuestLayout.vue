<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { ArrowRightOnRectangleIcon } from '@heroicons/vue/24/outline';
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="leading-normal tracking-normal text-gray-900">
        <div class="h-screen pb-14 bg-right bg-cover" style="background-image:url('/bg.svg');">
            <!--Nav-->
            <div class="w-full container mx-auto p-6">

                <div class="w-full flex items-center justify-between">
                    <a class="flex items-center text-indigo-400 no-underline hover:no-underline font-bold text-2xl lg:text-2xl"
                        href="/">
                        <img src="@/assets/logo.png" class="w-10 mr-4" /> Waste Monitoring
                    </a>
                    <div class="flex">
                        <Inertia-Link
                            class="inline-block text-indigo-600 no-underline hover:text-indigo-800 hover:text-underline text-center h-10 p-2 md:h-auto md:p-4 uppercase "
                            :class="{ 'font-bold': route().current('home') }" href="/">
                            Нүүр хуудас
                        </Inertia-Link>
                        <Inertia-Link
                            class="inline-block text-indigo-600 no-underline hover:text-indigo-800 hover:text-underline text-center h-10 p-2 md:h-auto md:p-4 uppercase "
                            :class="{ 'font-bold': route().current('dashboard') }" :href="route('dashboard')">
                            Статистик
                        </Inertia-Link>
                        <Inertia-Link
                            class="inline-block text-indigo-600 no-underline hover:text-indigo-800 hover:text-underline text-center h-10 p-2 md:h-auto md:p-4 uppercase "
                            :class="{ 'font-bold': route().current('reg.*') }" :href="route('reg.index')">
                            Бүртгэл
                        </Inertia-Link>
                    </div>
                    <div class="flex w-1/4 justify-end content-center">

                        <Inertia-Link
                            class="inline-block text-blue-300 no-underline hover:text-indigo-800 hover:text-underline text-center h-10 p-2 md:h-auto md:p-4 "
                            href="/login">
                            <ArrowRightOnRectangleIcon class="w-5 "></ArrowRightOnRectangleIcon>
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
