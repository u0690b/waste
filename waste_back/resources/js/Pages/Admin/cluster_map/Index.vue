<template>
    <div>
        <ol-map :loadTilesWhileAnimating="true" :loadTilesWhileInteracting="true" style="height:800px">

            <ol-view ref="view" :center="center" :rotation="rotation" :zoom="zoom" :projection="projection" />


            <ol-tile-layer>
                <ol-source-osm />
            </ol-tile-layer>

            <ol-vector-layer>

                <ol-source-cluster :ref="el => clusterRef = el" :distance="40">
                    <ol-interaction-clusterselect @select="featureSelected" :pointRadius="20">
                        <ol-style>
                            <ol-style-stroke color="green" :width="5"></ol-style-stroke>
                            <ol-style-fill color="rgba(255,255,255,0.5)"></ol-style-fill>
                            <ol-style-icon :src="markerIcon" :scale="0.05"></ol-style-icon>
                        </ol-style>
                    </ol-interaction-clusterselect>
                    <ol-source-vector>


                        <ol-feature v-for="index in 100" :key="index" :properties="{ id: index, name: 'haha' + index }">
                            <ol-geom-point
                                :coordinates="[getRandomInRange(105.924741, 107.924741, 3), getRandomInRange(46.9173283, 48.9173283, 3)]"></ol-geom-point>
                        </ol-feature>
                    </ol-source-vector>

                </ol-source-cluster>

                <ol-style :overrideStyleFunction="overrideStyleFunction">
                    <ol-style-stroke color="red" :width="2"></ol-style-stroke>
                    <ol-style-fill color="rgba(255,255,255,0.1)"></ol-style-fill>

                    <ol-style-circle :radius="10">
                        <ol-style-fill color="#3399CC"></ol-style-fill>
                        <ol-style-stroke color="#fff" :width="1"></ol-style-stroke>

                    </ol-style-circle>
                    <ol-style-text>
                        <ol-style-fill color="#fff"></ol-style-fill>
                    </ol-style-text>
                </ol-style>

            </ol-vector-layer>

        </ol-map>
    </div>
</template>
  
<script>
import Layout from "@/Layouts/Admin.vue";
import mapValues from "lodash/mapValues";
import Pagination from "@/Components/Pagination.vue";
import pickBy from "lodash/pickBy";
import SearchFilter from "@/Components/SearchFilter.vue";
import debounce from "lodash/debounce";
import AdminTable from "@/Components/AdminTable.vue";
import 'vue3-openlayers/dist/vue3-openlayers.css'
import { ref, inject } from "vue";
import markerIcon from './marker.png'

export default {
    metaInfo: { title: "Places" },
    components: {
        Pagination,
        SearchFilter,
        AdminTable,
    },
    setup(props) {
        const center = ref([106.9247419, 47.9173283])
        const projection = ref('EPSG:4326')
        const zoom = ref(13.8)
        const rotation = ref(0)
        const selectedCityName = ref()

        const overrideStyleFunction = (feature, style) => {

            let clusteredFeatures = feature.get('features');
            let size = clusteredFeatures.length;

            style.getText().setText(size.toString());

        }

        const getRandomInRange = (from, to, fixed) => {
            return (Math.random() * (to - from) + from).toFixed(fixed) * 1;

        }

        const featureSelected = (event) => {
            debugger
            if (event.selected.length == 1) {

                console.log(event.selected[0].get('id'));


                selectedCityName.value = event.selected[0].values_.name;
            } else {
                selectedCityName.value = '';
            }

        }



        return {
            center,
            projection,
            zoom,
            rotation,
            featureSelected,
            overrideStyleFunction,
            getRandomInRange,
            markerIcon,
        }
    },
    layout: Layout,
    props: {
        datas: Object,
        filters: [Object, Array],
        host: String,
    },
    data() {
        return {
            form: {
                ...(this.filters ? this.filters : {}),
            },
        };
    },
    computed: {
        myFeatures() {
            return this.datas.data.map(v => [v.lat, v.lng])
        }
    },
    watch: {
        form: {
            handler: debounce(function () {
                this.$inertia.get(this.route("admin.places.index"), pickBy(this.form), {
                    preserveState: true,
                });
            }, 150),
            deep: true,
        },
    },
    methods: {

        reset() {
            this.form = mapValues(this.form, () => null);
        },
    },
};
</script>
  