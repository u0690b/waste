<template>
    <GoogleMap api-key="AIzaSyBX2h1XKlleDEXJCKTekPVDk2lI2LNDFNc" style="width: 100%; height: 600px" :center="center"
        :zoom="zoom">

        <Marker :options="{ position: center, }" />
    </GoogleMap>
</template>

<script setup>
import { ref } from 'vue'
import { GoogleMap, Marker } from "vue3-google-map";
const props = defineProps({ coordinate: Array })
const center = ref({ lat: parseFloat(props.coordinate[1]), lng: parseFloat(props.coordinate[0]) })
const zoom = ref(16)
</script>

<style lang="scss" scoped>

</style>