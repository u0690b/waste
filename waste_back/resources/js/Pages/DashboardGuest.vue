<script setup>
import MyInput from "@/Components/MyInput.vue";
import { Inertia } from "@inertiajs/inertia";
import { Head } from "@inertiajs/inertia-vue3";
import debounce from "lodash/debounce";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";
import { reactive, watch, computed } from "vue";
import VueApexCharts from "vue3-apexcharts";
import SharedState from "@/Components/SharedState.vue";
import { TabList } from "@headlessui/vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";

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
  const regionChart = props.etgeed.reduce(function (r, a) {
    r[a.name] = r[a.name] || 0;
    r[a.name] = r[a.name] + a.niit;
    return r;
  }, {});
  return {
    chartOptions: {
      xaxis: {
        categories: Object.keys(regionChart),
      },
      yaxis: {
        labels: {
          show: false
        }
      },
      plotOptions: {
        bar: {
          borderRadius: 4,
          barHeight: '100%',
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
      tooltip: {
        theme: 'dark',
        x: {
          show: false
        },
        y: {
          title: {
            formatter: function () {
              return ''
            }
          }
        }
      },
      stroke: {
        width: 1,
        colors: ['#fff']
      },
      colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
        '#f48024', '#69d2e7'
      ],
    },

    series: [
      {

        data: Object.values(regionChart),
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

  <GuestLayout>
    <div class="container">


      <div class="ml-12 flex gap-2 py-6 items-center">
        <MyInput v-model="form.start" type="date" label="Эхлэх"></MyInput>
        <MyInput v-model="form.end" type="date" label="Дуусах"></MyInput>
        <span class="pt-6">
          {{ rangeDay }}
        </span>


      </div>
      <div class="grid grid-cols-1 px-4 gap-4 mt-8 sm:grid-cols-3 sm:px-8">
        <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow">
          <h3 class="text-xl text-gray-600 mb-4">Зөрчил төлвөөр</h3>
          <VueApexCharts class="bg-white p-4" type="pie" :options="statDonut.chartOptions" :series="statDonut.series">
          </VueApexCharts>
        </div>
        <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow col-span-2">
          <h3 class="text-xl text-gray-600 mb-4">Зөрчлийн төрлөөр</h3>
          <VueApexCharts class="bg-white mb-8 p-4" type="bar" height="350" :options="dateOptions.chartOptions"
            :series="dateOptions.series">
          </VueApexCharts>
        </div>
      </div>
      <div class="grid grid-cols-1 px-4 gap-4 mt-8 sm:grid-cols-3 sm:px-8">
        <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow col-span-2">
          <h3 class="text-xl text-gray-600 mb-4">Харъяалагдах нутаг дэвсгэрээр</h3>
          <VueApexCharts class="bg-white mb-8 p-4" type="bar" height="350" :options="regionOptions.chartOptions"
            :series="regionOptions.series">
          </VueApexCharts>
        </div>
        <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow">
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
  </GuestLayout>
</template>
