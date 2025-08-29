<script setup lang="ts">

import Carousel from '@/components/My/Carousel.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { WasteModel } from '@/types/type';
import { Head } from '@inertiajs/vue3';
import { StepperItem } from '@nuxt/ui';
import { computed, ref } from 'vue';
import { GoogleMap, Marker } from 'vue3-google-map';

import PersistentLayout from '@/layouts/PersistentLayout.vue';

defineOptions({layout: PersistentLayout})

const props = defineProps<{ waste: WasteModel }>()

const breadcrumbs = [
    {
        title: 'Дашбоард',
        href: route('dashboard'),
    },
    props.waste.status_id == 4 ?
        {
            title: 'Шийдвэрлэсэн',
            href: route('solved'),
        } : {
            title: 'Илгээсэн',
            href: route('send'),
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

        { label: 'Аймаг,Нийслэл', value: props.waste?.aimag_city.name ?? '' },
        { label: 'Сум,Дүүрэг', value: props.waste?.soum_district.name ?? '' },
        { label: 'Баг,Хороо', value: props.waste?.bag_horoo.name ?? '' },
        { label: 'Хаяг, байршилд', value: props.waste?.address },
        { label: 'Гаргасан зөрчлийн байдал', value: props.waste?.description },
        { label: 'Зөрчлийн төрөл', value: props.waste?.reason.name ?? '' },
        { label: 'Зөрчсөн хууль тогтоомжийн зүйл, заалт', value: props.waste?.zuil_zaalt },
        { label: 'Уртраг', value: props.waste?.long },
        { label: 'Өргөрөг', value: props.waste?.lat },
        { label: 'Бүртгэсэн хүн', value: props.waste?.reg_user?.firstname ?? '' },
        { label: 'Үүсгэсэн', value: props.waste?.created_at },
        { label: 'Төлөв', value: props.waste?.status?.name ?? 'Илгээгээгүй' },

    ],
    ...props.waste?.status_id == 4 ? [
        { label: 'Шийдвэрийн төрөл', value: props.waste?.resolve?.name ?? '' },
        { label: 'Шийдвэрлэсэн байдал', value: props.waste?.resolve_desc },
        { label: 'Шийдвэрлэсэн зураг', value: props.waste?.resolve_image },
        { label: 'Шийдвэрлэсэн огноо', value: props.waste?.resolved_at },
        { label: 'Шийдвэрлэсэн', value: props.waste?.comf_user_name ?? '' },
        { label: 'Шилжүүлсэн', value: props.waste?.allocated?.name ?? '' },
        { label: 'Хуваарилсан', value: props.waste?.comf_user?.name ?? '' },
        { label: 'Хуваарилсан огноо', value: props.waste?.reg_at },

    ] : [],
    ...props.waste?.status_id == 3 ? [
        { label: 'Шилжүүлсэн', value: props.waste?.allocated?.name ?? '' },
        { label: 'Хуваарилсан', value: props.waste?.comf_user?.name ?? '' },
        { label: 'Хуваарилсан огноо', value: props.waste?.reg_at },

    ] : [],
]


// { label: 'Иргэн/ААН', value: props.waste?.whois },


const center = computed(() => ({ lat: props.waste?.lat, lng: props.waste?.long }))
const attached_images = computed(() => {
    lat:
    return props.waste.attached_images?.map(v => v.path) ?? []
})
const step = computed(() => {
    lat:
    return (props.waste?.status_id ?? 2) - 2
})

const items = ref<StepperItem[]>([
    {
        title: 'Илгээсэн',
        description: props.waste?.reg_user?.firstname ?? '',
        icon: 'i-lucide-rocket'
    },
    {
        title: 'Хүлээн авсан',
        description: props.waste?.comf_user?.name ?? '',
        icon: 'i-lucide-truck'
    },
    {
        title: 'Шийдвэрлэх',
        icon: 'i-lucide-laptop-minimal-check',
        description: (props.waste?.comf_user_name ?? '') + ": " + props.waste?.resolve_desc,
    }
])
</script>

<template>

    <Head :title="props.waste?.name ?? 'Дэлгэрэнгүй'" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="p-4   rounded shadow pb-10">
            <div class="grid gap-2">
                <UStepper :model-value="step" size="xs" disabled :items="items" class="w-full" orientation="vertical" />
                <GoogleMap api-key="AIzaSyBX2h1XKlleDEXJCKTekPVDk2lI2LNDFNc" class="w-full h-56" :center="center"
                    :zoom="15">
                    <Marker :options="{ position: center }" />
                </GoogleMap>
                <div v-for="item in fields" :key="item.label" v-bind="item" class="text-xs  font-medium text-gray-700 ">
                    <p class="mr-2  text-muted">{{ item.label }}: </p>
                    <span class="">{{ item.value }}</span>
                </div>
                <Carousel :items="attached_images" />
            </div>
        </div>
    </AppLayout>


</template>
