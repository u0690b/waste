<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { useWasteListStore } from '@/composables/WasteStore';
import AppLayout from '@/layouts/AppLayout.vue';
import { base64ToFile } from '@/lib/utils';
import WasteDetail from '@/pages/waste/WasteDetail.vue';
import { Auth, type BreadcrumbItem } from '@/types';
import { WasteModel } from '@/types/type';
import { Head, router } from '@inertiajs/vue3';
import { LoaderIcon } from 'lucide-vue-next';
import { ref } from 'vue';
import Edit from './Edit.vue';
import { useIsOnlineStore } from '@/composables/useIsOnline';
import PersistentLayout from '@/layouts/PersistentLayout.vue';

defineOptions({
    layout: PersistentLayout,
})


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Дашбоард',
        href: route('dashboard'),
    },
    {
        title: 'Илгээгээгүй',
        href: route('draft'),
    },
];

defineProps<{ auth: Auth }>();

const wasteStore = useWasteListStore();
const waste = ref<WasteModel>();

const sended = () => {
    wasteStore.wasteList = wasteStore.wasteList.filter((v) => JSON.stringify(v) !== JSON.stringify(waste.value));
    waste.value = undefined;
};

const open = ref(false);
const isEdit = ref(false);
const send = () => {
    const data = { ...waste.value };

    open.value = true;
    data.images = [];
    data.imageBase64List?.forEach((v, i) => {
        (data.images ??= []).push(base64ToFile(v, `img${i}.png`));
    });
    delete data.imageBase64List;
    router.post(
        route('store'),
        {
            _method: 'put',
            ...data,
        },
        {
            forceFormData: true,
            headers: { back: new URLSearchParams(window.location.search).get('callback') ?? '' },
            preserveScroll: true,
            replace: true,
            onSuccess: () => {
                sended();
                console.log('succes');
            },
            onFinish: () => {
                open.value = false;
            },
        },
    );
};
const isOnlineStore = useIsOnlineStore();
const done= ()=>{
    isEdit.value=false;
    waste.value=undefined;
}
</script>

<template>
    <template v-if="!isEdit">
        <template v-if="waste == null">
            <Head title="Дашбоард" />

            <AppLayout :breadcrumbs="breadcrumbs">
                <div class="mt-8 grid gap-2 px-2">
                    <div v-if="wasteStore.wasteList.length == 0" class="text-center">
                        <Heading title="Харуулах мэдээлэл алга" description="Та шинээр бүртгэх боломжтой" />
                    </div>
                    <UCard
                        v-for="(value, i) in wasteStore.wasteList"
                        :key="i + 'hehe'"
                        @click="waste = value"
                        class="hover:bg-gray-200 active:bg-gray-300 dark:hover:bg-gray-600"
                    >
                        <div class="flex items-center justify-between gap-2">
                            <UAvatar :src="value.imageBase64List?.[0] ?? undefined" class=""></UAvatar>
                            <div class="flex-1 pl-2">
                                <p>{{ value.name }}</p>
                                <div class="w-full truncate overflow-hidden text-xs text-pretty hyphens-auto text-muted">
                                    <p>{{ value.address }}</p>
                                    <p>{{ value.description }}</p>
                                </div>
                            </div>
                            <UButton
                            v-if="isOnlineStore.isOnline"
                                @click="send"
                                title="Сервэрт илгээх"
                                icon="i-lucide-rocket"
                                color="success"
                                variant="subtle"
                                :ui="{ leadingIcon: 'text-primary' }"
                            >
                            </UButton>
                        </div>
                    </UCard>
                </div>
            </AppLayout>
        </template>
        <template v-else>
            <WasteDetail :waste="waste" islocal @send="send" @edit="isEdit = true" />
        </template>
        <UModal :dismissible="false" v-model:open="open" :close="false">
            <template #body>
                <LoaderIcon class="mx-auto animate-spin"></LoaderIcon>
                <p class="text-center">Илгээж байна</p>
            </template>
        </UModal>
    </template>
    <template v-else>
        <Edit :auth="auth" :waste="waste"  @done="done"/>
    </template>
</template>
