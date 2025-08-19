<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { CardTitle, CardDescription, Card, CardContent } from '@/components/ui/card';
import { computed } from 'vue';
import { useWasteListStore } from '@/composables/WasteStore';
import { Plus } from 'lucide-vue-next';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Дашбоард',
        href: route('dashboard'),
    },
];
const props = defineProps<{
    status: any[]
}>()

const wasteStore = useWasteListStore();
const draftTotal = computed(()=>{
    return wasteStore.wasteList.length
})

const card = [
    {
        change: "Нийт зөрчил",
        icon: "lucide:file-text",
        total: (props.status?.reduce((v, a) => a.total + v, 0)??0) + draftTotal.value,
    },
    {
        change: "Илгээгээгүй",
        icon: "lucide:save-off",
        total: draftTotal.value ?? '0',

    },
    {
        change: "Илгээсэн",
        icon: "lucide:send",
        total: props.status?.find(v => v.status_id == 2)?.total ?? '0',

    },
    {
        change: "Ажиллгаа хийгдэж байгаа",
        icon: "lucide:truck",
        total: props.status?.find(v => v.status_id == 3)?.total ?? '0',
    },
    {
        change: "Шийдвэрлэсэн",
        icon: "lucide:badge-check",
        total: props.status?.find(v => v.status_id == 3)?.total ?? '0',
    }
]
</script>

<template>

    <Head title="Дашбоард" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto ">
            <div class="grid auto-rows-min gap-4 grid-cols-2 md:grid-cols-3">
                <Card v-for="value,i in card" :key="i">
                    <CardContent>
                        <CardTitle class="flex justify-between">
                            <div class="text-3xl font-bold">{{ value.total }}</div>
                            <UIcon :name="value.icon" />
                        </CardTitle>
                        <CardDescription>{{ value.change }}</CardDescription>
                    </CardContent>

                </Card>
                <ILink ::href="route('create')" as="button" class="rounded-md border bg-primary w-full h-full" title="Зөрчил бүртгэх">
                    <Plus :size="40" class="text-white mx-auto" />
                </ILink>
            </div>
        </div>
    </AppLayout>
</template>
