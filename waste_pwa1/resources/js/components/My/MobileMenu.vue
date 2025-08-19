<script setup lang="ts">
import { NavItem } from '@/types';


defineProps<{ menus: NavItem[] }>();

</script>

<template>
    <div class="mt-96 ">
        <div
            class="fixed bottom-0 z-50 w-full -translate-x-1/2 bg-white border-t border-gray-200 left-1/2 dark:bg-gray-700 dark:border-gray-600">

            <div class="grid h-full max-w-lg grid-cols-5 mx-auto">
                <template v-for="menu in menus" :key="menu.href">
                    <UTooltip :text="menu.title">
                        <ULink target="_self" :href="menu.href" active-class="bg-gray-200"
                            class="inline-flex flex-col items-center justify-center p-4 hover:bg-gray-50 data-active:bg-black dark:hover:bg-gray-800 group">

                            <component :is="menu.icon" />
                            <span class="sr-only"> {{ menu.title }}</span>
                        </ULink>
                    </UTooltip>

                </template>
            </div>

        </div>
    </div>

</template>
