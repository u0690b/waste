<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <h2 class="text-2xl text-gray-600">Зөрчлийн бүртгэл</h2>
    <div class="flex items-center space-x-1 text-xs">
      <router-link to="/" class="font-bold text-indigo-700">Нүүр хуудас</router-link>
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
      <span class="text-gray-600">Зөрчлийн бүртгэл</span>
    </div>
  </div>
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
            placeholder="Search user"
          />
        </div>
        <inertia-link
          class="flex items-center bg-green-500 p-2 text-white rounded text-sm hover:bg-green-600"
          :href="route('admin.registers.create')"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 mr-1"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 6v6m0 0v6m0-6h6m-6 0H6"
            />
          </svg>
          <span class="hidden md:inline">Registers</span>
        </inertia-link>
      </div>
      <admin-table
        :headers="{
          name: 'Байгууллага, аж ахуйн нэгжийн нэр, иргэний овог нэр',
          register: 'Регистрийн дугаар',
          chiglel: 'Үйл ажиллагааны чиглэл',
          'aimag_city.name': 'Аймаг,Нийслэл',
          aimag_city_id: 'Аймаг,Нийслэл',
          'soum_district.name': 'Сум,Дүүрэг',
          soum_district_id: 'Сум,Дүүрэг',
          'bag_horoo.name': 'Баг,Хороо',
          bag_horoo_id: 'Баг,Хороо',
          address: 'Хаяг, байршилд',
          description: 'Гаргасан зөрчилийн байдал',
          'reason.name': 'Зөрчилийн төрөл',
          reason_id: 'Зөрчилийн төрөл',
          zuil_zaalt: 'Зөрчсөн хууль тогтоомжийн зүйл, заалт',
          resolve_desc: 'Зөрчлийг шийдвэрлэсэн байдал',
          long: 'Уртраг',
          lat: 'Өргөрөг',
          'reg_user.name': 'Бүртгэсэн хүн',
          reg_user_id: 'Бүртгэсэн хүн',
          'comf_user.name': 'Шийдвэрлэсэн хүн',
          comf_user_id: 'Шийдвэрлэсэн хүн',
          'status.name': 'Төлөв',
          status_id: 'Төлөв',
        }"
        :datas="datas"
        url="admin.registers.edit"
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
export default {
  metaInfo: { title: "Registers" },
  components: {
    Pagination,
    SearchFilter,
    AdminTable,
    MySelect,
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
        reason_id: null,
        reg_user_id: null,
        comf_user_id: null,
        status_id: null,
        ...(this.filters ? this.filters : {}),
      },
    };
  },
  watch: {
    form: {
      handler: debounce(function () {
        this.$inertia.get(this.route("admin.registers.index"), pickBy(this.form), {
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
