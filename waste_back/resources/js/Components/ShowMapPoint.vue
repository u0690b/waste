<template>
    <ol-map :loadTilesWhileAnimating="true" :loadTilesWhileInteracting="true" style="height:400px">

        <ol-view ref="view" :center="center" :rotation="rotation" :zoom="zoom" :projection="projection" />

        <ol-tile-layer>
            <ol-source-osm />
        </ol-tile-layer>

        <ol-vector-layer>
            <ol-source-vector>
                <ol-feature>
                    <ol-geom-point :coordinates="coordinate"></ol-geom-point>
                    <ol-style>
                        <ol-style-circle :radius="radius">
                            <ol-style-fill :color="fillColor"></ol-style-fill>
                            <ol-style-stroke :color="strokeColor" :width="strokeWidth"></ol-style-stroke>
                        </ol-style-circle>
                    </ol-style>
                </ol-feature>

            </ol-source-vector>

        </ol-vector-layer>

    </ol-map>
</template>

<script setup>
import { ref } from 'vue'
import 'vue3-openlayers/dist/vue3-openlayers.css'
const props = defineProps({ coordinate: Array })
const center = ref(props.coordinate)
const projection = ref('EPSG:4326')
const zoom = ref(16)
const rotation = ref(0)
const radius = ref(5)
const strokeWidth = ref(2)
const strokeColor = ref('red')
const fillColor = ref('white')
const coordinate = ref(props.coordinate)
</script>

<style lang="scss" scoped>

</style>