<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <h2 class="text-2xl text-gray-600 underline font-bold">Хэрэглэгч жагсаалт</h2>
    <div class="flex items-center space-x-1 text-xs">
      <inertia-link href="/" class="font-bold text-indigo-700">Нүүр хуудас</inertia-link>
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-2 w-2"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M9 5l7 7-7 7"
        />
      </svg>
      <span class="text-gray-600">Хэрэглэгч</span>
    </div>
  </div>
  <SharedState></SharedState>
  <div class="p-4 mt-8 sm:px-8 sm:py-4">
    <div class="p-4 bg-white rounded">
      <div class="mb-6 flex justify-between items-center">
        <div class="relative text-gray-400">
          <span class="absolute inset-y-0 left-0 flex items-center pl-2">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
              />
            </svg>
          </span>
          <input
            id="search"
            name="search"
            type="search"
            v-model="form.search"
            class="w-full py-2 text-sm text-gray-900 rounded-md pl-10 border border-gray-300 focus:outline-none focus:ring-gray-500 focus:ring-gray-500 focus:z-10"
            placeholder="Хэрэглэгч хайх"
          />
        </div>
      </div>
      <admin-table
        :headers="{
          name: 'Хэрэглэгчийн нэр',
          username: 'Нэвтрэх нэр',

          'aimag_city.name': 'Аймаг/нийслэл',

          'soum_district.name': 'Сум/дүүрэг',

          'bag_horoo.name': 'Баг/хороо',

          roles: 'Эрх',
        }"
        :datas="datas"
        url="admin.users"
      />
    </div>
    <pagination :links="datas.links" />
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
import MySelect from "@/Components/MySelect.vue";
import SharedState from "@/Components/SharedState.vue";
export default {
  metaInfo: { title: "Users Models" },
  components: {
    Pagination,
    SearchFilter,
    AdminTable,
    MySelect,
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
        aimag_city_id: null,
        soum_district_id: null,
        bag_horoo_id: null,
        ...(this.filters ? this.filters : {}),
      },
    };
  },
  watch: {
    form: {
      handler: debounce(function () {
        this.$inertia.get(this.route("admin.users.index"), pickBy(this.form), {
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
