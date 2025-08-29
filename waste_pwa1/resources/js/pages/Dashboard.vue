<script setup lang="ts">
import { Card, CardContent, CardDescription, CardTitle } from '@/components/ui/card';
import { useWasteListStore } from '@/composables/WasteStore';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { computed } from 'vue';
import PersistentLayout from '@/layouts/PersistentLayout.vue';

defineOptions({
    layout: PersistentLayout,
})

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Дашбоард',
        href: route('dashboard'),
    },
];
const props = defineProps<{
    status: any[];
}>();

const wasteStore = useWasteListStore();
const draftTotal = computed(() => {
    return wasteStore.wasteList.length;
});

const card = [
    {
        change: 'Нийт зөрчил',
        icon: 'lucide:file-text',
        total: (props.status?.reduce((v, a) => a.total + v, 0) ?? 0) + draftTotal.value,
    },
    {
        change: 'Илгээгээгүй',
        icon: 'lucide:save-off',
        href: route('draft'),
        total: draftTotal.value ?? 0,
    },
    {
        change: 'Илгээсэн',
        icon: 'lucide:send',
        href: route('send'),
        total: props.status?.find((v) => v.status_id == 2)?.total ?? 0,
    },
    {
        change: 'Ажиллагаа хийгдэж байгаа',
        icon: 'lucide:truck',
        href: route('send'),
        total: props.status?.find((v) => v.status_id == 3)?.total ?? 0,
    },
    {
        change: 'Шийдвэрлэсэн',
        icon: 'lucide:badge-check',
        href: route('solved'),
        total: props.status?.find((v) => v.status_id == 3)?.total ?? 0,
    },
];
</script>

<template>
    <Head title="Дашбоард" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min grid-cols-2 gap-4 md:grid-cols-3">
                <Card
                    v-for="(value, i) in card"
                    :key="i"
                    @click="
                        () => {
                            value.href && router.visit(value.href);
                        }
                    "
                >
                    <CardContent>
                        <CardTitle class="flex justify-between">
                            <div class="text-3xl font-bold">{{ value.total }}</div>
                            <UIcon :name="value.icon" />
                        </CardTitle>
                        <CardDescription>{{ value.change }}</CardDescription>
                    </CardContent>
                </Card>
                <ILink :href="route('create')" as="button" class="block h-full w-full rounded-md border bg-primary" title="Зөрчил бүртгэх">
                    <Plus :size="40" class="mx-auto text-white" />
                </ILink>
            </div>
        </div>
    </AppLayout>
</template>
