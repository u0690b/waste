<script setup>
import MyInput from "@/Components/MyInput.vue";
import Admin from "@/Layouts/Admin.vue";
import { Inertia } from "@inertiajs/inertia";
import { Head } from "@inertiajs/inertia-vue3";
import debounce from "lodash/debounce";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";
import { reactive, watch, computed } from "vue";
import VueApexCharts from "vue3-apexcharts";
import SharedState from "@/Components/SharedState.vue";
import { TabList } from "@headlessui/vue";

const props = defineProps({
  datas: Object,
  chart: [Array],
  etgeed: [Array],
  irgen: [Array],
  filters: [Object, Array],
  host: String,
});
let form = reactive({
  ...props.filters,
});
const reset = () => (form = mapValues(form, () => null));

watch(
  () => form,
  debounce(function () {
    Inertia.get("/dashboard", pickBy(form), { preserveState: true });
  }, 150),
  { deep: true }
);

const dateOptions = computed(() => {
  const ognooLabels = props.chart.reduce((r, a) => {
    if (!r.includes(a.ognoo)) r.push(a.ognoo);
    return r;
  }, []);

  return {
    series: props.chart.reduce(function (r, a) {
      let index = r.findIndex((v) => v.name == a.reason);

      if (index < 0) {
        let c = {
          name: a.reason,
          data: ognooLabels.map((x) => ({ x, y: 0 })),
        };
        index = r.length;
        r.push(c);
      }
      let yIndex = r[index].data.findIndex((v) => v.x == a.ognoo);

      if (yIndex < 0) {
        r[index].data.push({ x: a.ognoo, y: a.niit });
      } else {
        r[index].data[yIndex].y = r[index].data[yIndex].y + a.niit;
      }

      return r;
    }, []),
    chartOptions: {
      chart: {
        type: "bar",
        height: 350,
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: "55%",
          endingShape: "rounded",
        },
      },
      dataLabels: {
        enabled: false,
      },
      stroke: {
        show: true,
        width: 2,
        colors: ["transparent"],
      },
      xaxis: {},
      yaxis: {
        title: {
          text: "Нийт",
        },
      },
      fill: {
        opacity: 1,
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return "Нийт: " + val;
          },
        },
      },
    },
  };
});

const regionOptions = computed(() => {
  const regionChart = props.chart.reduce(function (r, a) {
    r[a.region] = r[a.region] || 0;
    r[a.region] = r[a.region] + a.niit;
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

const donut = computed(() => {
  const orgChart = props.chart.reduce(function (r, a) {
    r[a.org] = r[a.org] || 0;
    r[a.org] = r[a.org] + a.niit;
    return r;
  }, {});
  return {
    series: Object.values(orgChart),
    chartOptions: {
      chart: {
        type: "donut",
      },

      labels: Object.keys(orgChart),
      legend: {
        position: "top",
      },
    },
  };
});

const statDonut = computed(() => {
  const statChart = props.chart.reduce(function (r, a) {
    r[a.stat] = r[a.stat] || 0;
    r[a.stat] = r[a.stat] + a.niit;
    return r;
  }, {});
  return {
    series: Object.values(statChart),
    chartOptions: {
      chart: {
        type: "donut",
      },

      labels: Object.keys(statChart),
      plotOptions: {
        legend: {
          position: "top",
        },
      },
      responsive: [
        {
          breakpoint: 480,
          options: {
            chart: {
              width: 300,
            },
            legend: {
              position: "left",
            },
          },
        },
      ],
      legend: {
        position: "top",
      },
    },
  };
});
const etgeedOptions = computed(() => {

  return {
    chartOptions: {
      chart: {
        type: 'bar'
      },
      xaxis: {
        categories: props.etgeed.map(v => v.name),
      },
      yaxis: {
        labels: {
          show: false
        }
      },
      plotOptions: {
        bar: {
          borderRadius: 4,
          distributed: true,
          horizontal: true,

        }
      },
      dataLabels: {
        enabled: true,
        textAnchor: 'start',
        style: {
          colors: ['#fff']
        },
        formatter: function (val, opt) {
          return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
        },
        offsetX: 0,
        dropShadow: {
          enabled: true
        }
      },

      colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
        '#f48024', '#69d2e7'
      ],
    },
    series: [
      {
        data: props.etgeed.map(v => v.niit),
      },
    ],
  };
});

const irgenOptions = computed(() => {

  return {
    chartOptions: {
      chart: {
        type: 'bar'
      },
      xaxis: {
        categories: props.irgen.map(v => v.name),
      },
      yaxis: {
        labels: {
          show: false
        }
      },
      plotOptions: {
        bar: {
          borderRadius: 4,
          distributed: true,
          horizontal: true,

        }
      },
      dataLabels: {
        enabled: true,
        textAnchor: 'start',
        style: {
          colors: ['#fff']
        },
        formatter: function (val, opt) {
          return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
        },
        offsetX: 0,
        dropShadow: {
          enabled: true
        }
      },

      colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
        '#f48024', '#69d2e7'
      ],
    },
    series: [
      {
        data: props.irgen.map(v => v.niit),
      },
    ],
  };
});
const rangeDay = computed(() => {

  let difference = Date.parse(form.end) - Date.parse(form.start);
  return (isNaN(difference) ? '~' : Math.ceil(difference / (1000 * 3600 * 24))) + ' өдрийн мэдээ';
});
</script>

<template>

  <Head title="Үндсэн хуудас" />

  <Admin>
    <div>
      <div class="flex justify-between px-4 mt-4 sm:px-8">
        <h2 class="text-xl text-gray-600">
          <inertia-link class="text-black hover:text-gray-800 font-bold flex" :href="route('dashboard')">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            Нүүр хуудас</inertia-link>
        </h2>
      </div>
      <SharedState></SharedState>
      <div class="ml-12 flex gap-2 py-6 items-center">
        <MyInput v-model="form.start" type="date" label="Эхлэх"></MyInput>
        <MyInput v-model="form.end" type="date" label="Дуусах"></MyInput>
        <span class="pt-6">
          {{ rangeDay }}
        </span>

        <div class="flex-1 flex w-full justify-end mr-8 fade-in">
          <img src="@/assets/App_Store.svg" class="h-12 pr-4 bounce-top-icons">
          <a href="/app_v1.apk">
            <img src="@/assets/Play_Store.svg" class="h-12 bounce-top-icons">
          </a>
        </div>
      </div>
      <div class="grid grid-cols-1 px-4 gap-4 mt-8 sm:grid-cols-3 sm:px-8">
        <div class="px-4 py-2 bg-white border rounded-md shadow">
          <h3 class="text-xl text-gray-600 mb-4">Нийт зөрчил төлвөөр</h3>
          <VueApexCharts class="bg-white p-4" type="pie" :options="statDonut.chartOptions" :series="statDonut.series">
          </VueApexCharts>
        </div>
        <div class="px-4 py-2 bg-white border rounded-md shadow col-span-2">
          <h3 class="text-xl text-gray-600 mb-4">Зөрчлийн төрлөөр</h3>
          <VueApexCharts class="bg-white mb-8 p-4" type="bar" height="350" :options="dateOptions.chartOptions"
            :series="dateOptions.series">
          </VueApexCharts>
        </div>
      </div>
      <div class="grid grid-cols-1 px-4 gap-4 mt-8 sm:grid-cols-3 sm:px-8">

        <div class="px-4 py-2 bg-white border rounded-md shadow col-span-2">
          <h3 class="text-xl text-gray-600 mb-4">Харъяалагдах нутаг дэвсгэрээр</h3>
          <VueApexCharts class="bg-white mb-8 p-4" type="bar" height="350" :options="regionOptions.chartOptions"
            :series="regionOptions.series">
          </VueApexCharts>
        </div>
        <div class="px-4 py-2 bg-white border rounded-md shadow">
          <h3 class="text-xl text-gray-600 mb-4">Зөрчил хуваарилалтаар</h3>
          <VueApexCharts class="bg-white p-4" type="pie" :options="donut.chartOptions" :series="donut.series">
          </VueApexCharts>
        </div>
      </div>
      <div class="grid grid-cols-2">
        <div class=" px-4 mx-4 mt-8 sm:mx-8  py-2 bg-white border rounded-md shadow">
          <h3 class="text-xl text-gray-600 mb-4">Олон зөрчил гаргасан аж ахуйн нэгжүүд</h3>
          <VueApexCharts class="bg-white mb-8 p-4" type="bar" height="350" :options="etgeedOptions.chartOptions"
            :series="etgeedOptions.series">
          </VueApexCharts>
        </div>
        <div class=" px-4 mx-4 mt-8 sm:mx-8  py-2 bg-white border rounded-md shadow">
          <h3 class="text-xl text-gray-600 mb-4">Олон зөрчил гаргасан иргэд</h3>
          <VueApexCharts class="bg-white mb-8 p-4" type="bar" height="350" :options="irgenOptions.chartOptions"
            :series="irgenOptions.series">
          </VueApexCharts>
        </div>
      </div>
    </div>
  </Admin>
</template>
