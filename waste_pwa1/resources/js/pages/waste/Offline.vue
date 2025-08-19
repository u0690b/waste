<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { WifiOff } from 'lucide-vue-next';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Дашбоард',
        href: route('dashboard'),
    },
    {
        title: 'Илгээсэн',
        href: route('draft'),
    },
];


</script>

<template>
    <Head title="Дашбоард" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full items-center justify-center">
                <WifiOff :size="154" class="text-muted -translate-y-9" />
        </div>
    </AppLayout>
</template>
