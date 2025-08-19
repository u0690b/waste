<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { WasteModel } from '@/types/type';
import { Rocket, RocketIcon, Ship, ShipIcon, Truck } from 'lucide-vue-next';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Дашбоард',
        href: '/',
    },
    {
        title: 'Илгээсэн',
        href: '/draft',
    },
];

defineProps<{ datas: WasteModel[] }>()
const more = (id:number)=>{
    router.visit(`/show/${id}`)
}

</script>

<template>

    <Head title="Дашбоард" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mt-8 px-2 grid gap-2">
            <div v-if="datas.length == 0" class="text-center">

                <Heading title="Харуулах мэдээлэл алга" description="Та шинээр бүртгүүлэх боломжтой" />
            </div>
            <UCard v-for="value, i in datas" :key="i + 'hehe'"
                class="hover:bg-gray-200 dark:hover:bg-gray-600 active:bg-gray-300 relative" @click="more(value.id!)">
                <UBadge class="right-1 top-1 absolute" :color="value.status_id==2? 'info':'primary'" variant="subtle">
                    <RocketIcon v-if="value.status_id == 2" :size="12" />
                    <Truck v-else :size="12" />
                </UBadge>
                <div class="flex items-center justify-between gap-2">

                    <UAvatar :src="value.attached_images?.[0]?.path ?? undefined" class=""></UAvatar>
                    <div class="flex-1 pl-2">
                        <p>{{ value.name }} </p>
                        <div class="text-muted text-xs truncate overflow-hidden text-pretty w-full hyphens-auto">
                            <p>{{ value.address }}</p>
                            <p>{{ value.comf_user?.name }}</p>
                        </div>
                    </div>
                </div>
            </UCard>
        </div>
    </AppLayout>

</template>
