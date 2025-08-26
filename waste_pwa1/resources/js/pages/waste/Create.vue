<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Auth, type BreadcrumbItem } from '@/types';
import { Head,    router,    useForm } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';
import { CustomControl, GoogleMap, Marker } from 'vue3-google-map'
import { vMaska } from "maska/vue"
import {  useCommonStore } from '@/composables/store';
import { useWasteListStore } from '@/composables/WasteStore';
import { WasteFormModel } from '@/types/type';


const props = defineProps<{ auth: Auth }>();

const center = ref({ lat: 40.689247, lng: -74.044502 });
const errMsg = ref();
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Бүртгэх',
        href: '',
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


const commonStore = useCommonStore();
const wasteStore = useWasteListStore()
const form = useForm<WasteFormModel>({
    model:{
        id:(new Date()).valueOf(),
        whois: false,
        name: undefined,
        register: undefined,
        chiglel: undefined,
        aimag_city_id: undefined,
        soum_district_id: undefined,
        bag_horoo_id: undefined,
        address: undefined,
        description: undefined,
        reason_id: undefined,
        zuil_zaalt: undefined,
        resolve_id: undefined,
        resolve_desc: undefined,
        resolve_image: undefined,
        long: undefined,
        lat: undefined,
        reg_user_id: props.auth.user.id,
        comf_user_id: undefined,
        status_id: 1,
        reg_at: undefined,
        resolved_at: undefined,
        allocate_by: undefined,
        imageFileList: undefined,
        imageBase64List:[],
        created_at: new Date().toISOString(),
    }
}).transform((data: any): WasteFormModel => data.model);;



onMounted(async () => {
    getCurrentLocation()
    // commonStore.fetchData()



})

const soumDistict = computed(()=>{
    return commonStore.commons?.soum_districts.filter(v => v.aimag_city_id == form.model.aimag_city_id)

})

const bagHoroo = computed(() => {
    return commonStore.commons?.bag_horoos.filter(v => v.soum_district_id == form.model.soum_district_id)
})
function fileToBase64(file:File, callback: (error: ProgressEvent<FileReader> | null, data: string | ArrayBuffer | null)=>void) {
    const reader = new FileReader();
    reader.readAsDataURL(file); // read file as base64 encoded string
    reader.onload = () => callback(null, reader.result);
    reader.onerror = (error) => callback(error, null);
}



const onSubmit = ()=>{
    form.model.long = center.value.lng;
    form.model.lat = center.value.lat;

    form.model.images!.forEach(element => {
        fileToBase64(element, (err, base64) => {
            if (err) {
                console.error("Error:", err);
            } else {
                if (typeof base64 === "string") {
                    (form.model.imageBase64List ??= []).push(base64);
                }
                console.log("Base64:", base64); // data:<mime>;base64,xxxx
            }
        });
    });

    wasteStore.wasteList.push(form.model)
    console.log("object");
    router.visit(route('draft'), { replace: true });
}
</script>

<template>

    <Head title="Дашбоард" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div>
            <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">

                <div class="relative rounded-md  p-1 ">
                    <GoogleMap api-key="AIzaSyBX2h1XKlleDEXJCKTekPVDk2lI2LNDFNc" style="width: 100%; height: 300px"
                        :center="center" :zoom="15">
                        <Marker :options="{ position: center }" />
                        <CustomControl position="LEFT_BOTTOM">
                            <UButton icon="lucide:locate" class="ml-4" @click="getCurrentLocation">
                            </UButton>
                        </CustomControl>
                    </GoogleMap>
                    {{ center.lat }},
                    {{ center.lng }}
                </div>
                <form @submit.prevent="onSubmit">
                    <div class="grid gap-3">
                        <USwitch v-model="form.model.whois" size="lg"
                            :label="!form.model.whois ? 'Хуулийн эргээд' : 'Иргэн'" />
                        <UFormField required v-if="!form.model.whois" hint="Зөрчил гаргасан иргэний." label="Овог нэр">
                            <UInput required size="lg" v-model="form.model.name" placeholder="Oвог Нэр"
                                class="w-full" />
                        </UFormField>
                        <UFormField required v-if="!form.model.whois" label="Регистер">
                            <UInput required size="lg" v-model="form.model.register" v-maska="'ZZ########'"
                                placeholder="xx########"
                                data-maska-tokens="{ 'Z': { 'pattern': '[a-zA-Z]|[А-Яа-яӨөҮүЁё]' }}" class=" w-full" />
                        </UFormField>

                        <UFormField required v-if="form.model.whois" hint="Зөрчил гаргасан иргэний."
                            label="Албан байгууллага нэр">
                            <UInput required size="lg" v-model="form.model.name" placeholder="Oвог Нэр"
                                class="w-full" />
                        </UFormField>
                        <UFormField required v-if="form.model.whois" label="Албан байгууллага регистер">
                            <UInput required size="lg" v-model="form.model.register" placeholder="Регистер"
                                class="w-full" />
                        </UFormField>

                        <UFormField required v-if="form.model.whois" label="Үйл ажиллагааний чиглэл">
                            <UInputMenu  openOnClick v-model="form.model.chiglel" valueKey="name" labelKey="name"
                                :items="commonStore.commons?.industry" placeholder="Үйл ажиллагааний чиглэл"
                                class="w-full" :search-input="{ icon: 'i-lucide-search' }" />
                        </UFormField>
                        <UFormField required label="Аймаг нийслэл">
                            <UInputMenu  openOnClick required size="lg" v-model="form.model.aimag_city_id" valueKey="id"
                                labelKey="name" :loading="commonStore.loading"
                                :items="commonStore.commons?.aimag_cities" placeholder="Аймаг нийслэл" class="w-full"
                                :search-input="{ icon: 'i-lucide-search' }"
                                @update:model-value="() => (form.model.bag_horoo_id = undefined)" />
                        </UFormField>
                        <UFormField v-if="form.model.aimag_city_id==undefined||form.model.aimag_city_id<23" required
                            label="Сум дүүрэг">
                            <UInputMenu  openOnClick required size="lg" v-model="form.model.soum_district_id" valueKey="id"
                                labelKey="name" :loading="commonStore.loading" :items="soumDistict"
                                placeholder="Сум дүүрэг" class="w-full" :search-input="{ icon: 'i-lucide-search' }"
                                @update:model-value="() => (form.model.bag_horoo_id=undefined)" />
                        </UFormField>
                        <UFormField v-if="form.model.aimag_city_id==undefined||form.model.aimag_city_id<23" required
                            label="Баг хороо">
                            <UInputMenu  openOnClick required size="lg" v-model="form.model.bag_horoo_id" valueKey="id"
                                labelKey="name" :loading="commonStore.loading" :items="bagHoroo"
                                placeholder="Сум дүүрэг" class="w-full" :search-input="{ icon: 'i-lucide-search' }" />
                        </UFormField>

                        <UFormField required label="Хаяг тоот, утас">
                            <UInput required size="lg" v-model="form.model.address" placeholder="Хаяг тоот, утас"
                                class="w-full" />
                        </UFormField>
                        <UFormField required label="Зөрчлийн төрөл">
                            <UInputMenu  openOnClick required size="lg" v-model="form.model.reason_id" valueKey="id" labelKey="name"
                                :loading="commonStore.loading" :items="commonStore.commons?.reasons"
                                placeholder="Сум дүүрэг" class="w-full" :search-input="{ icon: 'i-lucide-search' }">
                                <template #item="{ item }">
                                    <div v-if="item" class="hover:bg-gray-200 w-full ">
                                        <div class="text-muted text-xs">{{ item.sub_group }}</div>
                                        <div class="font-bold">{{ item.name }}</div>
                                    </div>
                                </template>
                            </UInputMenu>
                        </UFormField>
                        <UFormField required label="Гаргасан зөрчилийн байдал">
                            <UTextarea required size="lg" v-model="form.model.description"
                                placeholder="Гаргасан зөрчилийн байдал, тайлбар" class="w-full" />
                        </UFormField>
                        <UFormField required label="Зураг">
                            <UFileUpload size="lg" v-model="form.model.images" position="inside" multiple
                                class="w-full min-h-38" layout="list" accept="image/*" />
                        </UFormField>
                    </div>
                    <div class="mt-8 w-full flex">
                        <UButton class="ml-auto rounded-full px-8" size="lg" type="submit">Хадгалах</UButton>
                    </div>
                </form>
            </div>
        </div>

    </AppLayout>

</template>


