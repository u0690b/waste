<script setup lang="ts">
import { useWasteListStore } from '@/composables/WasteStore';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head} from '@inertiajs/vue3';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Дашбоард',
        href: '/',
    },
    {
        title: 'Илгээгээгүй',
        href: '/draft',
    },
];


const wasteStore = useWasteListStore();

const send = ()=>{
    console.log('haha');
}
</script>

<template>

    <Head title="Дашбоард" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mt-8 px-2">
            <UDrawer should-scale-background set-background-color-on-scale>
                <UButton label="Open" color="neutral" variant="subtle" trailing-icon="i-lucide-chevron-up" />

                <template #content>
                    <Placeholder class="h-screen m-4" />
                </template>
            </UDrawer>
            <UCard v-for="value in wasteStore.wasteList" :key="value.name + 'hehe'" @click="send"
                class="hover:bg-gray-200 active:bg-gray-300">
                <div class="flex items-center justify-between gap-2">
                    <UAvatar :src="value.imageBase64List?.[0]" class=""></UAvatar>
                    <div class="flex-1 pl-2">
                        <p>{{ value.name }}</p>
                        <div class="text-muted text-xs truncate overflow-hidden text-pretty w-full hyphens-auto">
                            <p>{{ value.address }}</p>
                            <p>{{ value.description }}</p>
                        </div>
                    </div>
                    <UButton @click="send" title="Сервэрт илгээх" icon="i-lucide-rocket" color="success"
                        variant="subtle" :ui="{leadingIcon: 'text-primary'}">

                    </UButton>
                </div>
            </UCard>
        </div>
    </AppLayout>

</template>
<style lang="css">

</style>
