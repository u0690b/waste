<script setup>
import MyInput from "@/Components/MyInput.vue";
import Admin from "@/Layouts/Admin.vue";

import { router as Inertia, Head } from "@inertiajs/vue3";
import debounce from "lodash/debounce";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";
import { reactive, watch, computed } from "vue";
import VueApexCharts from "vue3-apexcharts";
import SharedState from "@/Components/SharedState.vue";
import { ArrowRightIcon, CameraIcon, CheckCircleIcon, DocumentIcon, UserGroupIcon, WifiIcon } from "@heroicons/vue/24/outline";
import Home from "./Home.vue";


const props = defineProps({
    datas: Object,
    totalReportStat: [Object, Array, Number],
    totalClearStat: [Object, Array, Number],
    totalClearPrevMonthStat: [Object, Array, Number],
    totalReportPrevMonthStat: [Object, Array, Number],
    totalUsers: [Object, Array, Number],
    lastMonth: [Object, Array],
    filters: [Object, Array],
    chart: [Object, Array],
    host: String,
});

const regionOptions = computed(() => {
    const regionChart = props.lastMonth.reduce(function (r, a) {
        r[a.month] = r[a.month] || 0;
        r[a.month] = r[a.month] + a.count;
        return r;
    }, {});
    return {
        chartOptions: {
            xaxis: {
                categories: Object.keys(regionChart),
            },
        },
        series: [
            {
                name: "series-1",
                data: Object.values(regionChart),
            },
        ],
    };
});

</script>

<template>

    <Head title="Үндсэн хуудас" />

    <Admin>
        <div class="container ml-8">
            <div class="flex justify-between px-4 mt-4 sm:px-8">
                <h2 class="text-xl text-gray-600">
                    <ILink class="flex font-bold text-black hover:text-gray-800" :href="route('dashboard')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Нүүр хуудас
                    </ILink>
                </h2>
            </div>

            <div class="flex items-center gap-2 py-6 ml-12">



                <div class="flex justify-end flex-1 w-full gap-4 mr-8 fade-in">
                    <!-- <img src="@/assets/App_Store.svg" class="h-12 pr-4 bounce-top-icons"> -->
                    <a href="https://waste.mecc.gov.mn/waste.apk" target="_blank">
                        <img src="@/assets/Play_Store.svg" class="h-12 bounce-top-icons">
                    </a>
                    <a href="https://waste.mecc.gov.mn/mobile" target="_blank">
                        <img src="@/assets/pwa.png" class="h-12 bounce-top-icons">
                    </a>
                </div>
            </div>
            <Home :datas="props.datas" :chart="props.chart" :totalReportStat="props.totalReportStat"
                :totalClearStat="props.totalClearStat" :totalClearPrevMonthStat="props.totalClearPrevMonthStat"
                :totalReportPrevMonthStat="props.totalReportPrevMonthStat" :totalUsers="props.totalUsers"
                :lastMonth="props.lastMonth" :filters="props.filters" :host="props.host" />
        </div>
    </Admin>
</template>
