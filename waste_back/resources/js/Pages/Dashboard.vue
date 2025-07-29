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


  const props = defineProps({
    datas: Object,
    totalReportStat: [Object, Array],
    totalClearStat: [Object, Array],
    totalClearPrevMonthStat: [Object, Array],
    totalReportPrevMonthStat: [Object, Array],
    totalUsers: [Object, Array],
    lastMonth: [Object, Array],
    filters: [Object, Array],
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
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            Нүүр хуудас
          </ILink>
        </h2>
      </div>

      <div class="flex items-center gap-2 py-6 ml-12">

        <span class="pt-6">
          {{ rangeDay }}
        </span>

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
      <section class="mb-8">
        <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
          <div class="hover:shadow-xl border-4 border-solid  rounded-2xl border-[#406f47]">
            <div class="flex flex-row items-center justify-between pb-2 space-y-0 card-header">
              <h3 class="text-sm font-medium">Нийт мэдэгдэл</h3>
              <DocumentIcon class="w-6 h-6 text-muted-foreground" />
            </div>
            <div class="card-body">
              <div class="text-3xl font-bold">{{ totalReportStat.toString().replace(/\D/g, "") }}</div>
              <p class="text-xs text-muted-foreground">Өнгөрсөн сараас {{ totalReportPrevMonthStat.percentage_change }}%</p>
            </div>
          </div>
          <div class="hover:shadow-xl border-4 border-solid  rounded-2xl border-[#406f47]">
            <div class="flex flex-row items-center justify-between pb-2 space-y-0 card-header">
              <h3 class="text-sm font-medium">Нийт шийдвэрлэсэн</h3>
              <CheckCircleIcon class="w-6 h-6 text-muted-foreground" />
            </div>
            <div class="card-body">
              <div class="text-3xl font-bold">{{ totalClearStat.toString().replace(/\D/g, "") }}</div>
              <p class="text-xs text-muted-foreground">Энэ сар +{{ totalClearPrevMonthStat }} шийдвэрлэсэн</p>
            </div>
          </div>
          <div class="hover:shadow-xl border-4 border-solid  rounded-2xl border-[#406f47]">
            <div class="flex flex-row items-center justify-between pb-2 space-y-0 card-header">
              <h3 class="text-sm font-medium">Бид олуулаа</h3>
              <UserGroupIcon class="w-6 h-6 text-muted-foreground" />
            </div>
            <div class="card-body">
              <div><span class="text-3xl font-bold">{{ totalUsers }}</span> Хүн</div>
              <p class="text-xs text-muted-foreground">Бид нэмэгдсээр улам олуулаа болсоор</p>
            </div>
          </div>
          <div class="hover:shadow-lg flex flex-col justify-center card bg-[#dde9aa] ">
            <div class="pt-6 card-body">
              <h3 class="text-lg font-semibold">Хог хаягдал олсон уу?</h3>
              <p class="mb-4 text-sm ">хянан мэдээлж, эрүүл орчныг хамтдаа бүтээе.</p>
              <ILink type="button" href="admin/registers" variant="secondary" class="w-full btn btn-success">
                Мэдэгдэл гаргах
                <ArrowRightIcon class="w-3 ml-2" />
              </ILink>
            </div>
          </div>
        </div>
      </section>
      <div class="border-4 border-solid  rounded-2xl border-[#406f47]">
        <div class="grid grid-cols-2 gap-4">
          <div class="flex items-center">
            <div class="p-4 px-4  md:p-8 text-[#406f47]  sm:px-8 text-center" id="about" role="tabpanel" aria-labelledby="about-tab">
              <h2 class="mb-5 text-4xl font-extrabold tracking-tight slide-in-bottom">
                Хувийн хариуцлагаар эхлэх, нийтээр хамтрах!
              </h2>

              <!-- List -->
              <div class="gap-4 md:flex ">
                Ил задгай хаягдлыг багасгаж, хүний эрүүл мэнд, байгаль орчинд үзүүлэх сөрөг нөлөөг бууруулна. Хогийг эдийн засгийн эргэлтэд оруулж, Хог хаягдлыг хянан мэдээлж, эрүүл орчныг хамтдаа бүтээе.
              </div>
              <div class="mt-10">

              </div>
            </div>
          </div>
          <div><img src="@/assets/herobg.png" class="rounded-r-xl"></div>
        </div>
      </div>
      <section>
        <h2 class="text-3xl font-bold text-center text-[#406f47]  mt-24 mb-6">Хэрхэн ажилладаг вэ?</h2>
        <div class="grid grid-cols-3 gap-8 p-4 text-center">
          <div class="p-4 border-[#406f47] border-4  hover:shadow-lg inset-2 shadow-[#31A95D22]  rounded-lg ">
            <CameraIcon class="w-28 h-28 mb-4 text-[#406f47] mx-auto" />
            <h3 class="font-bold">Зураг авч, байршлыг оруулна</h3>
            <div class="card-body">
              Ил задгай хаягдсан хогийг гар утсаараа зураг авч, байршлын хамт системд илгээнэ.
            </div>
          </div>
          <div class="p-4 border-[#406f47] border-4 hover:shadow-lg inset-2 shadow-[#31A95D22]  rounded-lg ">
            <WifiIcon class="w-28 h-28 mb-4 text-[#406f47] mx-auto" />
            <h3 class="font-bold">Мэдээллийг дамжуулна</h3>
            <div class="card-body">
              Илгээсэн зураг, байршил нь хяналтын төвд очиж бүртгэгдэнэ. Холбогдох байгууллагууд мэдэгдэл авна.
            </div>
          </div>
          <div class="p-4 border-[#406f47] border-4 hover:shadow-lg inset-2 shadow-[#31A95D22]  rounded-lg">
            <CheckCircleIcon class="w-28 h-28 mb-4 text-[#406f47] mx-auto" />
            <h3 class="font-bold">Шийдвэрлэх ба хянах</h3>
            <div class="card-body">
              Хог хаягдлыг цэвэрлэсний дараа тухайн мэдээллийг шинэчилж, олон нийт хянах боломжтой болно.
            </div>
          </div>
        </div>
      </section>

      <section>
        <div className="border-[#406f47] border-4 hover:shadow-lg inset-2 shadow-[#31A95D22]  rounded-lg flex flex-col gap-6 animate-in fade-in-0 duration-500">

          <div class="grid gap-6 ">
            <div class="col-span-2 px-4 py-2 overflow-hidden bg-white border rounded-md shadow">
              <h3 class="flex mb-4 text-xl text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                </svg>хаг тайлан</h3>
              <p>Сүүлийн 6 сар бүрийн бүртгэлийн тоо</p>

              <VueApexCharts class="p-4 mb-8 bg-white" type="bar" height="350" :options="regionOptions.chartOptions" :series="regionOptions.series">
              </VueApexCharts>
            </div>

          </div>
        </div>
      </section>
    </div>
  </Admin>
</template>
