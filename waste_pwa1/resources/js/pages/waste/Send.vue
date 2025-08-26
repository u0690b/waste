<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { WasteModel } from '@/types/type';
import { Head, router } from '@inertiajs/vue3';
import { RocketIcon, Truck } from 'lucide-vue-next';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Дашбоард',
        href: route('dashboard'),
    },
    {
        title: 'Илгээсэн',
        href: route('send'),
    },
];

defineProps<{ datas: WasteModel[] }>();
const more = (id: number) => {
    router.visit(route(`show`, id));
};
</script>

<template>
    <Head title="Дашбоард" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mt-8 grid gap-2 px-2">
            <div v-if="datas.length == 0" class="text-center">
                <Heading title="Харуулах мэдээлэл алга" description="Та шинээр бүртгэх боломжтой" />
            </div>
            <UCard
                v-for="(value, i) in datas"
                :key="i + 'hehe'"
                class="relative hover:bg-gray-200 active:bg-gray-300 dark:hover:bg-gray-600"
                @click="more(value.id!)"
            >
                <UBadge class="absolute top-1 right-1" :color="value.status_id == 2 ? 'info' : 'primary'" variant="subtle">
                    <RocketIcon v-if="value.status_id == 2" :size="12" />
                    <Truck v-else :size="12" />
                </UBadge>
                <div class="flex items-center justify-between gap-2">
                    <UAvatar :src="value.attached_images?.[0]?.path ?? undefined" class=""></UAvatar>
                    <div class="flex-1 pl-2">
                        <p>{{ value.name }}</p>
                        <div class="w-full truncate overflow-hidden text-xs text-pretty hyphens-auto text-muted">
                            <p>{{ value.address }}</p>
                            <p>{{ value.comf_user?.name }}</p>
                        </div>
                    </div>
                </div>
            </UCard>
        </div>
    </AppLayout>
</template>
