<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import AppearanceTabs from '@/components/AppearanceTabs.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/AppLayout.vue';


const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Тохиргоо',
        href: route('appearance'),
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">

        <Head title="Тохиргоо" />
        <div class="p-4  rounded shadow pb-10">
                <HeadingSmall title="Тохиргоо" description="" />
                <AppearanceTabs />
            </div>
    </AppLayout>
</template>
