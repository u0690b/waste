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
      <div class="grid px-4 gap-4 mt-8 sm:px-8 border">
        <div class="p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="about" role="tabpanel"
          aria-labelledby="about-tab">
          <h2 class="mb-5 text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white slide-in-bottom">
            Системийн зорилго
            хүрэх үр дүн:
          </h2>
          <!-- List -->
          <ul role="list" class="space-y-4 text-gray-500 dark:text-gray-400">
            <li class="flex space-x-2">
              <!-- Icon -->
              <svg class="flex-shrink-0 w-4 h-4 text-blue-600 dark:text-blue-500 slide-in-bottom" fill="currentColor"
                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span class="font-light leading-tight slide-in-bottom">Хог хаягдлын олон нийтийн байцаагч /ОНБ/-ийн
                зөрчлийн тэмдэглэл
                хөтлөх үйлдэл цахимжин хялбар болж, зөрчлийн
                мэдээллийн цахим сан бий болно</span>
            </li>
            <li class="flex space-x-2">
              <!-- Icon -->
              <svg class="flex-shrink-0 w-4 h-4 text-blue-600 dark:text-blue-500 slide-in-bottom" fill="currentColor"
                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span class="font-light leading-tight slide-in-bottom">Аливаа зөрчлийн мэдээллийг хариуцсан эрх бүхий
                байгууллага, албан
                тушаалтанд шуурхай хүргэн, шийдвэрлүүлнэ</span>
            </li>
            <li class="flex space-x-2">
              <!-- Icon -->
              <svg class="flex-shrink-0 w-4 h-4 text-blue-600 dark:text-blue-500 slide-in-bottom" fill="currentColor"
                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span class="font-light leading-tight slide-in-bottom">Зөрчил үүсгэж байгаа иргэн, аж ахуй нэгж,
                байгууллагын нэрс,
                зөрчлийн мэдээлэл, зөрчлийн шийдвэрлэлтийн явц,
                үр дүн олон нийтэд нээлттэй ил тод болно</span>
            </li>
            <li class="flex space-x-2">
              <!-- Icon -->
              <svg class="flex-shrink-0 w-4 h-4 text-blue-600 dark:text-blue-500 slide-in-bottom" fill="currentColor"
                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span class="font-light leading-tight slide-in-bottom">Нийслэл, дүүргийн асуудал хариуцсан холбогдох нэгж,
                хэлтсүүд хот,
                дүүргийн хэмжээнд гарч байгаа зөрчлийн тоо
                хэмжээ, төрөл, түүний шийдвэрлэлтийг тухай бүр хянах, шаардлагатай тайланг гаргах, дээд шатны удирдлагыг
                мэдээллээр шуурхай хангана</span>
            </li>
            <li class="flex space-x-2">
              <!-- Icon -->
              <svg class="flex-shrink-0 w-4 h-4 text-blue-600 dark:text-blue-500 slide-in-bottom" fill="currentColor"
                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"></path>
              </svg>
              <span class="font-light leading-tight slide-in-bottom">Монгол Улсын Үндсэн хуульд заасан иргэний эрүүл,
                аюулгүй орчинд
                амьдрах нөхцөл бүрдэнэ</span>
            </li>
          </ul>
        </div>

      </div>
      <div class="ml-12 flex gap-2 py-6 items-center">
        <MyInput v-model="form.start" type="date" label="Эхлэх"></MyInput>
        <MyInput v-model="form.end" type="date" label="Дуусах"></MyInput>
        <span class="pt-6">
          {{ rangeDay }}
        </span>
      </div>
      <div class="grid grid-cols-1 px-4 gap-4 mt-8 sm:grid-cols-3 sm:px-8">
        <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow">
          <h3 class="text-xl text-gray-600 mb-4 flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
            </svg>Зөрчлийн төлөв</h3>
          <VueApexCharts class="bg-white p-4" type="pie" :options="statDonut.chartOptions" :series="statDonut.series">
          </VueApexCharts>
        </div>
        <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow col-span-2">
          <h3 class="text-xl text-gray-600 mb-4 flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
            </svg>Зөрчлийн төрлөөр</h3>
          <VueApexCharts class="bg-white mb-8 p-4" type="bar" height="350" :options="dateOptions.chartOptions"
            :series="dateOptions.series">
          </VueApexCharts>
        </div>
      </div>
      <div class="grid grid-cols-1 px-4 gap-4 mt-8 sm:grid-cols-3 sm:px-8">
        <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow col-span-2">
          <h3 class="text-xl text-gray-600 mb-4 flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
            </svg>Харъяалагдах нутаг дэвсгэрээр</h3>
          <VueApexCharts class="bg-white mb-8 p-4" type="bar" height="350" :options="regionOptions.chartOptions"
            :series="regionOptions.series">
          </VueApexCharts>
        </div>
        <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow">
          <h3 class="text-xl text-gray-600 mb-4 flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
            </svg>Зөрчил хуваарилалтаар</h3>
          <VueApexCharts class="bg-white p-4" type="pie" :options="donut.chartOptions" :series="donut.series">
          </VueApexCharts>
        </div>

      </div>
      <div class="grid grid-cols-2">
        <div class=" px-4 mx-4 mt-8 sm:mx-8  py-2 bg-white border rounded-md shadow">
          <h3 class="text-xl text-gray-600 mb-4 flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
            </svg>
            Олон зөрчил гаргасан аж ахуйн нэгжүүд</h3>
          <VueApexCharts class="bg-white mb-8 p-4" type="bar" height="350" :options="etgeedOptions.chartOptions"
            :series="etgeedOptions.series">
          </VueApexCharts>
        </div>
        <div class=" px-4 mx-4 mt-8 sm:mx-8  py-2 bg-white border rounded-md shadow">
          <h3 class="text-xl text-gray-600 mb-4 flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
            </svg>
            Олон зөрчил гаргасан иргэд</h3>
          <VueApexCharts class="bg-white mb-8 p-4" type="bar" height="350" :options="irgenOptions.chartOptions"
            :series="irgenOptions.series">
          </VueApexCharts>
        </div>
      </div>

    </div>

    <!--Footer-->
    <div class="grid grid-cols-1 px-4 gap-4 mt-8 sm:grid-cols-4 sm:px-8">
      <a href="http://www.ubservice.mn/?fbclid=IwAR0DRdfuer1AfiIURNjUTtXk4-XIjHP3H2dRBMwLw-dcMwQ1WA11mxS0fMc"
        target="_blank"><img src="../../../public/img/zaa1.jpg"
          class="object-contain w-48 ... px-4 slide-in-bottom" /></a>
      <a href="http://inspection.gov.mn/new/" target="_blank"><img src="../../../public/img/mergejil.jpg"
          class="object-contain w-48 ... slide-in-bottom" /></a>
      <a href="https://www.eda.admin.ch/countries/mongolia/mn/home/chegzhlijn.html" target="_blank"><img
          src="../../../public/img/sha.png" class="object-contain w-48 ... px-4 slide-in-bottom" /></a>
    </div>
    <div class="w-full pt-5 pb-5 my-20 text-sm text-center md:text-left fade-in bg-gray-100">
      Developed by Лансерс ХХК /Хуулбарлахыг хориглоно
      <a class="text-gray-500 no-underline hover:no-underline" href="#">&copy; {{ (new
        Date()).getFullYear()
      }} он</a>
    </div>
  </GuestLayout>
</template>
