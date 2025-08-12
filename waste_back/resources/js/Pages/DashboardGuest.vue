<script setup>
import MyInput from "@/Components/MyInput.vue";
import { router as Inertia } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import debounce from "lodash/debounce";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";
import { reactive, watch, computed } from "vue";
import VueApexCharts from "vue3-apexcharts";
import SharedState from "@/Components/SharedState.vue";
import { TabList } from "@headlessui/vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { ArrowRightIcon, CameraIcon, CheckBadgeIcon, CheckCircleIcon, DocumentCheckIcon, DocumentIcon, UserGroupIcon, WifiIcon } from "@heroicons/vue/24/outline";
import Home from "./Home.vue";

const props = defineProps({
    datas: Object,
    chart: [Object, Array],
    totalReportStat: [Object, Array, Number],
    totalClearStat: [Object, Array, Number],
    totalClearPrevMonthStat: [Object, Array, Number],
    totalReportPrevMonthStat: [Object, Array, Number],
    totalUsers: [Object, Array, Number],
    lastMonth: [Object, Array],
    filters: [Object, Array],
    host: String,
});



</script>
<template>

    <Head title="Үндсэн хуудас" />
    <GuestLayout>
        <div class="container px-2 sm:p-0">


            <Home :datas="props.datas" :chart="props.chart" :totalReportStat="props.totalReportStat"
                :totalClearStat="props.totalClearStat" :totalClearPrevMonthStat="props.totalClearPrevMonthStat"
                :totalReportPrevMonthStat="props.totalReportPrevMonthStat" :totalUsers="props.totalUsers"
                :lastMonth="props.lastMonth" :filters="props.filters" :host="props.host" />

        </div>

    </GuestLayout>
</template>
