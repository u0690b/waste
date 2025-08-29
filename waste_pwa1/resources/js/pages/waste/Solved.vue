<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { WasteModel } from '@/types/type';
import PersistentLayout from '@/layouts/PersistentLayout.vue';

defineOptions({layout: PersistentLayout})

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Дашбоард',
        href: route('dashboard'),
    },
    {
        title: 'Шийдвэрлэсэн',
        href: route('solved'),
    },
];

defineProps<{ datas: WasteModel[] }>()
const more = (id: number) => {
    router.visit(route(`show`, id))
}

</script>

<template>

    <Head title="Дашбоард" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mt-8 px-2 grid gap-2">

            <UCard v-for="value, i in datas" :key="i + 'hehe'"
                class="hover:bg-gray-200 active:bg-gray-300 dark:hover:bg-gray-600" @click="more(value.id!)">
                <div class="flex items-center justify-between gap-2">
                    <UAvatar :src="value.attached_images?.[0]?.path ?? undefined" class=""></UAvatar>
                    <div class="flex-1 pl-2">
                        <p>{{ value.name }}</p>
                        <div class="text-muted text-xs truncate overflow-hidden text-pretty w-full hyphens-auto">
                            <p>{{ value.address }}</p>
                            <p>{{ value.description }}</p>
                        </div>
                    </div>
                </div>
            </UCard>
        </div>
    </AppLayout>

</template>
