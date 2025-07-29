<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <h2 class="flex text-xl font-bold text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
      </svg>
      Төлөв жагсаалт</h2>
    <div class="flex items-center space-x-1 text-xs">
      <ILink href="/" class="text-sm font-bold text-indigo-700">Нүүр хуудас</ILink>
      <svg xmlns="http://www.w3.org/2000/svg" class="w-2 h-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <span class="text-sm text-gray-600">Төлөв</span>
    </div>
  </div>
  <div class="p-4 mt-8 sm:px-8 sm:py-4">
    <div class="px-4 py-2 bg-white border rounded-md shadow">
      <h3 class="mb-2 text-xl text-gray-600">Төлвийн тайлбар</h3>

      <div class="flex flex-col">
        <div class="inline-block min-w-full align-middle">
          <div class="overflow-hidden border-0">
            <table class="min-w-full divide-y divide-gray-200 table-auto">
              <thead>
                <tr>
                  <th scope="col" class="py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                    Төлөв
                  </th>

                  <th scope="col" class="py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                    Тайлбар
                  </th>
                </tr>
              </thead>
              <tbody class="text-sm text-gray-500 divide-y divide-gray-200">

                <tr>
                  <td class="py-1">
                    <span class="px-2 py-1 text-xs text-white bg-orange-500 rounded ">Илгээсэн</span>
                  </td>
                  <td class="py-1 text-sm text-gray-500">Cистемд илгээсэн үед үүсэх
                    төлөв</td>
                </tr>

                <tr>
                  <td class="py-1"> <span class="px-2 py-1 text-xs text-white bg-green-500 rounded ">Шийдвэрлэсэн</span>
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
      <div class="flex items-center justify-between mb-6">
        <div class="relative text-gray-400">
          <span class="absolute inset-y-0 left-0 flex items-center pl-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </span>
          <input id="search" name="search" type="search" v-model="form.search" class="w-full py-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-md focus:outline-none focus:ring-gray-500 focus:z-10" placeholder="Төлөв хайх" />
        </div>
      </div>
      <admin-table :headers="{ name: 'Төлөв' }" :datas="datas" url="admin.statuses.edit" />
      <div class="flex items-center justify-between py-2 border-t border-gray-200 ">
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
