<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <h2 class="text-xl text-gray-600 font-bold">Төлөв жагсаалт</h2>
    <div class="flex items-center space-x-1 text-xs">
      <inertia-link href="/" class="font-bold text-indigo-700 text-sm">Нүүр хуудас</inertia-link>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <span class="text-gray-600 text-sm">Төлөв</span>
    </div>
  </div>
  <div class="p-4 mt-8 sm:px-8 sm:py-4">
    <div class="px-4 py-2 bg-white border rounded-md shadow">
      <h3 class="text-xl text-gray-600 mb-2">Төлвийн тайлбар</h3>

      <div class="flex flex-col">
        <div class="align-middle inline-block min-w-full">
          <div class="overflow-hidden border-0">
            <table class="table-auto min-w-full divide-y divide-gray-200">
              <thead>
                <tr>
                  <th scope="col" class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Төлөв
                  </th>

                  <th scope="col" class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Тайлбар
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 text-sm text-gray-500">
                <tr>
                  <td class="py-1">
                    <span class=" px-2 py-1 rounded text-xs text-white bg-red-500">Бүртгэсэн</span>
                  </td>
                  <td class="py-1 text-sm text-gray-500">Хог хаягдлын олон нийтийн байцаагч мобайл аппликешн програмд
                    зөрчлийг бүртгэсэн үед үүсэх төлөв </td>
                </tr>
                <tr>
                  <td class="py-1">
                    <span class=" px-2 py-1 rounded text-xs text-white bg-orange-500">Илгээсэн</span>
                  </td>
                  <td class="py-1 text-sm text-gray-500">Хог хаягдлын олон нийтийн байцаагч системд илгээсэн үед үүсэх
                    төлөв</td>
                </tr>
                <tr>
                  <td class="py-1"> <span class=" px-2 py-1 rounded text-xs text-white bg-blue-500">Хуваарилсан</span>
                  </td>
                  <td class="py-1 text-sm text-gray-500">Хариуцсан байцаагч болон мэргэжилтэнд тухайн зөрчлийг
                    оногдуулсан үед үүсэх төлөв</td>
                </tr>
                <tr>
                  <td class="py-1"> <span class=" px-2 py-1 rounded text-xs text-white bg-green-500">Шийдвэрлэсэн</span>
                  </td>
                  <td class="py-1 text-sm text-gray-500">Тухайн зөрчлийг арилгаж шийдвэрлэсэн үед үүсэх төлөв
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
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
            class="w-full py-2 text-sm text-gray-900 rounded-md pl-10 border border-gray-300 focus:outline-none focus:ring-gray-500 focus:ring-gray-500 focus:z-10"
            placeholder="Төлөв хайх" />
        </div>
      </div>
      <admin-table :headers="{ name: 'Төлөв' }" :datas="datas" url="admin.statuses.edit" />
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
import SharedState from "@/Components/SharedState.vue";

export default {
  metaInfo: { title: "Statuses" },
  components: {
    Pagination,
    SearchFilter,
    AdminTable,
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
        this.$inertia.get(this.route("admin.statuses.index"), pickBy(this.form), {
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
