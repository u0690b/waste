<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, WhenVisible } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';
import { CustomControl, GoogleMap, Marker } from 'vue3-google-map'
import { vMaska } from "maska/vue"
import { NamedRow, useCommonStore, useCounterStore } from '@/composables/store';
import { storeToRefs } from 'pinia';
import { FormModel } from './Create.vue';
import { Card, CardContent } from '@/components/ui/card';
import CardTitle from '@/components/ui/card/CardTitle.vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Дашбоард',
        href: '/dashboard',
    },
    {
        title: 'Илгээсэн',
        href: '/draft',
    },
];


const commonStore = useCommonStore();

const datas = ref<FormModel[]>([
{
    name: "ovogner",
    register: "register",
    whois: null,
    chiglel: null,
    aimag_city_id: null,
    soum_district_id: null,
    bag_horoo_id: null,
    address: 'Улаан баатар Баянгол 2-р хороо хашаатийн 10',
    description: "baildal",
    reason_id: null,
    zuil_zaalt: null,
    resolve_id: null,
    resolve_desc: null,
    resolve_image: null,
    long: null,
    lat: null,
    reg_user_id: null,
    comf_user_id: null,
    status_id: null,
    reg_at: null,
    resolved_at: null,
    allocate_by: null
}
])
</script>

<template>

    <Head title="Дашбоард" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mt-8 px-2">

            <UCard v-for="value in datas" :key="value.name + 'hehe'">
                <div class="flex items-center justify-between gap-2">
                    <UAvatar class=""></UAvatar>
                    <div class="flex-1 pl-2">
                        <p>{{ value.name }}</p>
                        <div class="text-muted text-xs truncate overflow-hidden text-pretty w-full hyphens-auto">
                            <p >{{ value.address }}</p>
                            <p>{{ value.description }}</p>
                        </div>
                    </div>

                </div>
            </UCard>
        </div>
    </AppLayout>

</template>
