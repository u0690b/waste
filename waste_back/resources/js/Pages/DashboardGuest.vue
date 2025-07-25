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
      <div class="grid gap-4 px-4 mt-8 sm:px-8 ">

        <div class="p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="about" role="tabpanel" aria-labelledby="about-tab">
          <h2 class="mb-5 text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white slide-in-bottom">
            Системийн зорилго хүрэх үр дүн:
          </h2>

          <!-- List -->
          <div class="gap-4 md:flex">
            Хог хаягдлаас хүний эрүүл мэнд, байгаль орчинд үзүүлэх сөрөг нөлөөллийг бууруулах, түүнээс урьдчилан сэргийлэх, хог хаягдлыг эдийн засгийн эргэлтэд оруулж, байгалийн нөөц баялгийг хэмнэх, иргэдийн хог хаягдлын талаархи боловсролыг дээшлүүлэх зорилгоор хог хаягдлыг ил задгай хаяхыг хянах мэдээлэх зорилготой

          </div>

        </div>

      </div>
      <div class="flex items-center gap-2 py-6 ml-12">
        <MyInput v-model="form.start" type="date" label="Эхлэх"></MyInput>
        <MyInput v-model="form.end" type="date" label="Дуусах"></MyInput>
        <span class="pt-6">
          {{ rangeDay }}
        </span>
      </div>
      <div class="grid grid-cols-1 gap-4 px-4 mt-8 sm:grid-cols-3 sm:px-8">
        <div class="px-4 py-2 overflow-hidden bg-white border rounded-md shadow">
          <h3 class="flex mb-4 text-xl text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
            </svg>Зөрчлийн төлөв</h3>
          <VueApexCharts class="p-4 bg-white" type="pie" :options="statDonut.chartOptions" :series="statDonut.series">
          </VueApexCharts>
        </div>
        <div class="col-span-2 px-4 py-2 overflow-hidden bg-white border rounded-md shadow">
          <h3 class="flex mb-4 text-xl text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
            </svg>Зөрчлийн төрлөөр</h3>
          <VueApexCharts class="p-4 mb-8 bg-white" type="bar" height="350" :options="dateOptions.chartOptions" :series="dateOptions.series">
          </VueApexCharts>
        </div>
      </div>
      <div class="grid grid-cols-1 gap-4 px-4 mt-8 sm:grid-cols-3 sm:px-8">
        <div class="col-span-2 px-4 py-2 overflow-hidden bg-white border rounded-md shadow">
          <h3 class="flex mb-4 text-xl text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
            </svg>Харьяалагдах нутаг дэвсгэрээр</h3>
          <VueApexCharts class="p-4 mb-8 bg-white" type="bar" height="350" :options="regionOptions.chartOptions" :series="regionOptions.series">
          </VueApexCharts>
        </div>
        <div class="px-4 py-2 overflow-hidden bg-white border rounded-md shadow">
          <h3 class="flex mb-4 text-xl text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
            </svg>Зөрчил хуваарилалтаар</h3>
          <VueApexCharts class="p-4 bg-white" type="pie" :options="donut.chartOptions" :series="donut.series">
          </VueApexCharts>
        </div>

      </div>
      <div class="grid grid-cols-2">
        <div class="px-4 py-2 mx-4 mt-8 bg-white border rounded-md shadow sm:mx-8">
          <h3 class="flex mb-4 text-xl text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
            </svg>
            Олон зөрчил гаргасан аж ахуйн нэгжүүд</h3>
          <VueApexCharts class="p-4 mb-8 bg-white" type="bar" height="350" :options="etgeedOptions.chartOptions" :series="etgeedOptions.series">
          </VueApexCharts>
        </div>
        <div class="px-4 py-2 mx-4 mt-8 bg-white border rounded-md shadow sm:mx-8">
          <h3 class="flex mb-4 text-xl text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
            </svg>
            Олон зөрчил гаргасан иргэд</h3>
          <VueApexCharts class="p-4 mb-8 bg-white" type="bar" height="350" :options="irgenOptions.chartOptions" :series="irgenOptions.series">
          </VueApexCharts>
        </div>
      </div>

    </div>

  </GuestLayout>
</template>
