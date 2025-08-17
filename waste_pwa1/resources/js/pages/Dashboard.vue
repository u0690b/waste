<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { CardTitle, CardDescription, Card, CardContent, CardAction } from '@/components/ui/card';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Дашбоард',
        href: '/dashboard',
    },
];
const props = defineProps({
    chart: [Object, Array],
    totalReportStat: [Number],
    totalClearStat: [Number],
    totalClearPrevMonthStat: [Number],
    totalReportPrevMonthStat: [Object],
    totalUsers: [Number],
    lastMonth: [Object, Array],
})



const card = [
    {
        title: "Нийт зөрчил",
        icon: "lucide:file-text",
        total: props.totalReportStat?.toString().replace(/\D/g, "") ?? '',
        change_title: "Өнгөрсөн сараас",
        change: 'Өнгөрсөн сараас ' + (props.totalReportPrevMonthStat?.percentage_change ?? '') + "%"
    },
    {
        title: "Нийт шийдвэрлэсэн",
        icon: "lucide:badge-check",
        total: props.totalClearStat?.toString().replace(/\D/g, "") ?? '',
        change_title: "Энэ сар",
        change: 'Энэ сар +' + (props.totalClearPrevMonthStat ?? '') + " шийдвэрлэсэн"
    },
    {
        title: "Нийт хэрэглэгч",
        icon: "lucide:badge-check",
        total: props.totalUsers?.toString().replace(/\D/g, "") ?? '',
        change_title: "Бид нэмэгдсээр улам олуулаа болсоор",
        change: ""
    }
]
</script>

<template>

    <Head title="Дашбоард" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="grid auto-rows-min gap-4 md:grid-cols-4">
                <Card v-for="value in card" :key="value.title">
                    <CardContent>
                        <CardTitle class="flex justify-between">
                            <h3 class="text-sm font-medium">{{value.title}}</h3>
                            <UIcon :name="value.icon" />
                        </CardTitle>
                        <div class="text-3xl font-bold">{{ value.total }}</div>
                        <CardDescription>{{ value.change }}</CardDescription>
                    </CardContent>

                </Card>
                <Card class="bg-green-400">
                    <CardContent>

                        <CardDescription class="mb-3">Байгалиа хайрлаж, бохирдлыг багасгах нь хүн бүрийн үүрэг</CardDescription>
                        <CardAction>
                            <UButton href="/create" trailing-icon="lucide:plus" color="neutral">Зөрчил бүртгэх</UButton>
                        </CardAction>
                    </CardContent>
                </Card>
            </div>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <PlaceholderPattern />
            </div>
        </div>
    </AppLayout>
</template>
