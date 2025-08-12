<template>
    <Layout>

        <div class="flex p-4 bg-gray">
            <MySelect v-model="form.model.soum_district_id" class="w-52" label="Дүүрэг сонгох"
                :url="`/admin/soum_districts`" />
            <MySelect v-model="form.model.status_id" class="px-3 w-52" label="Төлөв сонгох" :url="`/admin/statuses`" />
        </div>

        <GoogleMap api-key="AIzaSyBX2h1XKlleDEXJCKTekPVDk2lI2LNDFNc" mapId="DEMO_MAP_ID" style="width: 100%; "
            class="h-[calc(100vh-200px)]" :center="center" :zoom="15">

            <MarkerCluster>
                <Marker v-for="(location, i) in datas" :key="i" :options="parseLocation(location)"
                    @click="() => onclick(location)" />


            </MarkerCluster>
        </GoogleMap>

    </Layout>
</template>

<script setup>
import Layout from "@/Layouts/Admin.vue";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";
import debounce from "lodash/debounce";

import { GoogleMap, Marker, MarkerCluster } from 'vue3-google-map'
import { router as Inertia, useForm } from "@inertiajs/vue3";
import MySelect from "@/Components/MySelect.vue";
import { watch } from "vue";
const props = defineProps({
    datas: Object,
    filters: { type: Object, default: () => ({ search: '' }) },

});

const emit = defineEmits(["update"]);

// Define the center of the map and marker options
const center = { lat: parseFloat(47.9173283), lng: parseFloat(106.9247419) };
const markerOptions = { position: center, label: "L", title: "LADY LIBERTY" };
const onclick = (location) => {
    Inertia.visit(`/admin/registers/${location.id}`);
    console.log(location);
}

const parseLocation = (location) => {
    return {
        position: { lat: parseFloat(location.lat), lng: parseFloat(location.long) },
        label: location.status_id == 2 ? 'И' : location.status_id == 3 ? 'X' : location.status_id == 4 ? 'Ш' : '',
        icon: location.status_id == 2 ? red : location.status_id == 3 ? orange : location.status_id == 4 ? blue : '',
    }
}

const form = useForm({ model: { ...props.filters } })
    .transform(data => data.model)

watch(() => form.model, debounce(() => form.get('', { preserveState: true }), 150), { deep: true })
const red = 'http://maps.google.com/mapfiles/kml/paddle/red-blank.png'
const orange = 'http://maps.google.com/mapfiles/kml/paddle/orange-blank.png'
const blue = 'http://maps.google.com/mapfiles/kml/paddle/grn-blank.png'


</script>
