<template>
  <Head title="Зөрчлийн бүртгэл" />

  <!-- <SharedState></SharedState> -->
  <div class="p-4 mt-8 sm:px-8 sm:py-4">
    <div class="p-4  rounded">
      <div class=" mb-6 flex justify-center items-center">
        <div class="relative text-gray-400">
          <span class="absolute inset-y-0 left-0 flex items-center pl-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </span>
          <input id="search" name="search" type="search" v-model="form.search"
            class="w-full py-2 text-sm text-gray-900 rounded-md pl-10 border border-gray-300 focus:outline-none focus:ring-gray-500  focus:z-10"
            placeholder="Бүртгэл хайх" />
        </div>

      </div>
      <div>
        <AdminCard :headers="headers" :datas="datas" showRoute="reg.show"></AdminCard>
      </div>
      <!-- <admin-table :headers="headers" :datas="datas" url="admin.registers.edit" /> -->
    </div>
    <pagination :links="datas.links" />
  </div>
</template>

<script>
import Layout from "@/Layouts/GuestLayout.vue";
import mapValues from "lodash/mapValues";
import Pagination from "@/Components/Pagination.vue";
import pickBy from "lodash/pickBy";
import SearchFilter from "@/Components/SearchFilter.vue";
import debounce from "lodash/debounce";
import AdminTable from "@/Components/AdminTable.vue";
import MySelect from "@/Components/MySelect.vue";
import AdminCard from "@/Components/AdminCard.vue";
import SharedState from "@/Components/SharedState.vue";
import { Head } from "@inertiajs/inertia-vue3";
export default {
  metaInfo: { title: "Registers" },
  components: {
    Pagination,
    SearchFilter,
    AdminTable,
    MySelect,
    AdminCard,
    SharedState,
    Head
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
      headers: {
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
        description: 'Гаргасан зөрчлийн байдал',
        'reason.name': 'Зөрчлийн төрөл',
        reason_id: 'Зөрчлийн төрөл',
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
      },
    };
  },
  watch: {
    form: {
      handler: debounce(function () {
        this.$inertia.get('/reg', pickBy(this.form), {
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
