<script setup lang="ts">

import Carousel from '@/components/My/Carousel.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import {  WasteModel } from '@/types/type';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import { GoogleMap, Marker } from 'vue3-google-map';

const emit = defineEmits(['sended','send','edit'])

const props = withDefaults(defineProps<{ waste: WasteModel, islocal: boolean }>(), {
    islocal: false
});

const breadcrumbs = [
    {
        title: 'Дашбоард',
        href: route('dashboard'),
    },
    {
        title: 'Илгээгээгүй',
        href: route('draft'),
    },
    {
        title: props.waste?.name ?? '',
        href: '#',
    },
];
const fields = [
    ...[
        { label: 'Нэр', value: props.waste?.name },
        { label: 'Регистрийн дугаар', value: props.waste?.register },
    ],
    ...props.waste?.whois ? [] : [{ label: 'Үйл ажиллагааны чиглэл', value: props.waste?.chiglel }],
    ...[

        { label: 'Аймаг,Нийслэл', value: props.waste?.aimag_city_id ?? '' },
        { label: 'Сум,Дүүрэг', value: props.waste?.soum_district_id ?? '' },
        { label: 'Баг,Хороо', value: props.waste?.bag_horoo_id ?? '' },
        { label: 'Хаяг, байршилд', value: props.waste?.address },
        { label: 'Гаргасан зөрчлийн байдал', value: props.waste?.description },
        { label: 'Зөрчлийн төрөл', value: props.waste?.reason_id ?? '' },
        { label: 'Зөрчсөн хууль тогтоомжийн зүйл, заалт', value: props.waste?.zuil_zaalt },
        { label: 'Уртраг', value: props.waste?.long },
        { label: 'Өргөрөг', value: props.waste?.lat },
        { label: 'Бүртгэсэн хүн', value: props.waste?.reg_user?.firstname ?? '' },
        { label: 'Үүсгэсэн', value: props.waste?.created_at },
        { label: 'Төлөв', value: props.waste?.status_id ?? 'Илгээгээгүй' },

    ],
    ...props.waste?.status_id == 4 ? [
        { label: 'Шийдвэрийн төрөл', value: props.waste?.resolve_id ?? '' },
        { label: 'Шийдвэрлэсэн байдал', value: props.waste?.resolve_desc },
        { label: 'Шийдвэрлэсэн зураг', value: props.waste?.resolve_image },
        { label: 'Шийдвэрлэсэн огноо', value: props.waste?.resolved_at },
        { label: 'Шийдвэрлэсэн хүн', value: props.waste?.comf_user_id ?? '' },

        { label: 'Хуваарилсан хүн', value: props.waste?.allocate_user_id },
        { label: 'Үүсгэсэн', value: props.waste?.reg_at },

    ] : [],
    ...props.waste?.status_id == 3 ? [
        { label: 'Хуваарилсан хүн', value: props.waste?.allocate_user_id },
        { label: 'Үүсгэсэн', value: props.waste?.reg_at },

    ] : [],
]


// { label: 'Иргэн/ААН', value: props.waste?.whois },


const center = computed(() => ({ lat: props.waste?.lat, lng: props.waste?.long }))


</script>

<template>

    <Head :title="props.waste?.name ?? 'Дэлгэрэнгүй'" />

<AppLayout :breadcrumbs="breadcrumbs">
        <div class="relative">
            <UButton v-if="(props.waste!.status_id ?? 1) == 1" title="Сервэрт илгээх"
                @click="emit('edit')"
                icon="i-lucide-rocket" color="success" variant="subtle" :ui="{ leadingIcon: 'text-primary' }"
                class="fixed bottom-16 right-28 z-40">
                Засах
            </UButton>
            <UButton v-if="(props.waste!.status_id ?? 1) == 1" @click="emit('send')" title="Сервэрт илгээх"
                icon="i-lucide-rocket" color="success" variant="subtle" :ui="{ leadingIcon: 'text-primary' }"
                class="fixed bottom-16 right-2 z-40">
                Илгээх
            </UButton>
            <div class="p-4   rounded shadow pb-10">
                <div class="grid gap-2">
                    <GoogleMap api-key="AIzaSyBX2h1XKlleDEXJCKTekPVDk2lI2LNDFNc" class="w-full h-56" :center="center"
                        :zoom="15"
                        >
                        <Marker :options="{ position: center }" />
                    </GoogleMap>
                    <div v-for="item in fields" :key="item.label" v-bind="item"
                        class="text-xs  font-medium text-gray-700 ">
                        <p class="mr-2  text-muted">{{ item.label }}: </p>
                        <span class="">{{ item.value }}</span>
                    </div>
                    <Carousel :items="waste?.imageBase64List ?? []" />
                </div>
            </div>
        </div>
    </AppLayout>


</template>
