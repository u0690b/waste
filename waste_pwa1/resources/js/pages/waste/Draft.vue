<script setup lang="ts">
import WasteDetail from '@/pages/waste/WasteDetail.vue';
import { useWasteListStore } from '@/composables/WasteStore';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router} from '@inertiajs/vue3';
import { ref } from 'vue';
import { WasteModel } from '@/types/type';
import { base64ToFile } from '@/lib/utils';
import Heading from '@/components/Heading.vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Дашбоард',
        href: '',
    },
    {
        title: 'Илгээгээгүй',
        href: 'draft',
    },
];


const wasteStore = useWasteListStore();
const waste = ref<WasteModel>()


const sended = () => {
    wasteStore.wasteList = wasteStore.wasteList.filter(v => JSON.stringify(v) !== JSON.stringify(waste.value))
    waste.value=undefined

}

const send = () => {
    const data = { ...waste.value };

    data.images = []
    data.imageBase64List?.forEach((v, i) => {
        (data.images ??= []).push(base64ToFile(v, `img${i}.png`))
    })
    delete data.imageBase64List
    router.post('/store', {
        _method: 'put',
        ...data
    }, {
        forceFormData: true,
        headers: { back: new URLSearchParams(window.location.search).get("callback") ?? '' },
        preserveScroll: true,
        replace: true,
        onSuccess: () => {
            sended()
            console.log("succes");
        },
    })
}






</script>


<template >
    <template v-if="waste==null">

        <Head title="Дашбоард" />

        <AppLayout :breadcrumbs="breadcrumbs">
            <div class="mt-8 px-2 grid gap-2">
                <div v-if="wasteStore.wasteList.length==0" class="text-center">

                    <Heading title="Харуулах мэдээлэл алга" description="Та шинээр бүртгүүлэх боломжтой" />
                </div>
                <UCard v-for="value,i in wasteStore.wasteList" :key="i + 'hehe'" @click="waste = value"
                    class="hover:bg-gray-200 dark:hover:bg-gray-600 active:bg-gray-300">
                    <div class="flex items-center justify-between gap-2">
                        <UAvatar :src="value.imageBase64List?.[0]??undefined" class=""></UAvatar>
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
    <template v-else>
        <WasteDetail :waste="waste" islocal @send="send" />
    </template>
</template>
