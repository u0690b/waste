<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <h2 class="text-xl text-gray-600 font-bold">Байгууллага жагсаалт</h2>
    <div class="flex items-center space-x-1 text-xs">
      <inertia-link href="/" class="font-bold text-indigo-700 text-sm">Нүүр хуудас</inertia-link>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <span class="text-gray-600 text-sm">Байгууллага</span>
    </div>
  </div>
  <!-- <SharedState></SharedState> -->
  <div class="grid grid-cols-1 gap-2 px-6 mt-8 sm:grid-cols-3 sm:px-8">
    <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">

      <a href="http://inspection.gov.mn/new/" target="_blank"><img src="../../../../../public/img/mergejil.jpg"
          class="object-contain w-48 ..." /></a>

      <div class="px-4 text-gray-700">
        <h3 class="text-sm tracking-wider">Мэргэжлийн хяналтын ерөнхий газар</h3>
        <p class="text-3xl"></p>
      </div>
    </div>
    <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
      <a href="https://www.eda.admin.ch/countries/mongolia/mn/home/chegzhlijn.html" target="_blank"><img
          src="../../../../../public/img/sha.png" class="object-contain w-48 ..." /></a>
      <div class="px-4 text-gray-700">
        <h3 class="text-sm tracking-wider">Швейцарын хөгжлийн агентлаг</h3>
        <p class="text-3xl"></p>
      </div>
    </div>
    <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
      <a href="http://www.ubservice.mn/?fbclid=IwAR0DRdfuer1AfiIURNjUTtXk4-XIjHP3H2dRBMwLw-dcMwQ1WA11mxS0fMc"
        target="_blank"><img src="../../../../../public/img/zaa.png" class="object-contain w-20 ..." /></a>
      <div class="px-4 text-gray-700">
        <h3 class="text-sm tracking-wider">Улаанбаатар хотын Захирагчийн ажлын алба</h3>
        <p class="text-3xl"></p>
      </div>
    </div>
  </div>
  <div class="p-4 mt-8 sm:px-8 sm:py-4">
    <div class="p-4 bg-white rounded">
      <div class="mb-6 flex justify-between items-center">
        <div class="relative text-gray-400">
          <span class="absolute inset-y-0 left-0 flex items-center pl-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </span>
          <input id="search" name="search" type="search" v-model="form.search"
            class="w-full py-2 text-sm text-gray-900 rounded-md pl-10 border border-gray-300 focus:outline-none focus:ring-gray-500 focus:z-10"
            placeholder="Байгууллага хайх" />
        </div>
      </div>

      <admin-table :headers="{ name: 'Байгууллага нэр' }" :datas="datas" />
      <div class="py-2 flex items-center justify-between border-t border-gray-200 border">
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"></div>
        <div class="hidden sm:flex-2 sm:flex sm:items-center sm:justify-between">
          <pagination :links="datas.links" />
        </div>
      </div>
    </div>
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
import { DeviceTabletIcon } from "@heroicons/vue/24/outline";
import SharedState from "@/Components/SharedState.vue";

export default {
  metaInfo: { title: "Places" },
  components: {
    Pagination,
    SearchFilter,
    AdminTable,
    DeviceTabletIcon,
    SharedState,
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
