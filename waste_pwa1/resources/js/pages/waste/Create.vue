<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref, watch } from 'vue';
import { CustomControl, GoogleMap, Marker } from 'vue3-google-map'
import { vMaska } from "maska/vue"
import { useFetch } from '@/composables/useFetch';

const center = ref({ lat: 40.689247, lng: -74.044502 });
const errMsg = ref();
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Бүртгэх',
        href: '/dashboard',
    },
];
const success = (position: GeolocationPosition) => {
    console.log(position);
    center.value = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
    }

};

const error = (err: any) => {
    switch (err.code) {
        case err.PERMISSION_DENIED:
            errMsg.value = "User denied the request for Geolocation."
            break;
        case err.POSITION_UNAVAILABLE:
            errMsg.value = "Location information is unavailable."
            break;
        case err.TIMEOUT:
            errMsg.value = "The request to get user location timed out."
            break;
        case err.UNKNOWN_ERROR:
            errMsg.value = "An unknown error occurred."
            break;
    }
};
const getCurrentLocation = () => {
    navigator.geolocation.getCurrentPosition(success, error, { maximumAge: 30000, timeout: 27000, enableHighAccuracy: true });
}

const value = ref()


const { data: users, loading, error:fetchRrr, fetchData } = useFetch('/api/common', {
    transform: (data: { id: number, name: string }[]) => {
        return data?.map(user => ({
            label: user.name,
            value: String(user.id),
            avatar: { src: `https://i.pravatar.cc/120?img=${user.id}` }
        }))??[]
    }
});




onMounted(async () => {
    getCurrentLocation()

    // fetchData();


})
const isLegacy = ref(false)


</script>

<template>

    <Head title="Дашбоард" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">

            <div class="relative aspect-video rounded-md  p-1 ">
                <GoogleMap api-key="AIzaSyBX2h1XKlleDEXJCKTekPVDk2lI2LNDFNc" style="width: 100%; height: 500px"
                    :center="center" :zoom="15">
                    <Marker :options="{ position: center }" />
                    <CustomControl position="LEFT_BOTTOM">
                        <UButton icon="lucide:locate" class="ml-4" @click="getCurrentLocation">
                        </UButton>
                    </CustomControl>
                </GoogleMap>
            </div>
            <div>
                <USwitch v-model="isLegacy" :label="!isLegacy? 'Хуулийн эргээд':'Иргэн'" />
                <UFormField v-if="!isLegacy" label="Зөрил гаргасан иргэний овог нэр">
                    <UInput placeholder="Oвог Нэр" class="w-full" />
                </UFormField>
                <UFormField v-if="!isLegacy" label="Зөрил гаргасан иргэний регистер">
                    <UInput v-maska="'ZZ########'" placeholder="xx########"
                        data-maska-tokens="{ 'Z': { 'pattern': '[a-zA-Z]|[А-Яа-яӨөҮүЁё]' }}" class=" w-full" />
                </UFormField>

                <UFormField v-if="isLegacy" label="Зөрил гаргасан Албан байгууллага нэр">
                    <UInput placeholder="Oвог Нэр" class="w-full" />
                </UFormField>
                <UFormField v-if="isLegacy" label="Зөрил гаргасан Албан байгууллага регистер">
                    <UInput placeholder="Регистер" class="w-full" />
                </UFormField>

                <UFormField v-if="isLegacy" label="Үйл ажиллагааний чиглэл">
                    <USelectMenu v-model="value" :items="users" placeholder="Үйл ажиллагааний чиглэл" class="w-full"
                        :loading="loading" :search-input="{ icon: 'i-lucide-search' }" />
                </UFormField>
                <UFormField v-if="isLegacy" label="Үйл ажиллагааний чиглэл">
                    <USelectMenu v-model="value" :items="users" placeholder="Үйл ажиллагааний чиглэл" class="w-full"
                        :loading="loading" :search-input="{ icon: 'i-lucide-search' }" />
                </UFormField>

            </div>
        </div>
    </AppLayout>

</template>
