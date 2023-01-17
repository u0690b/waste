<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <h2 class="text-xl text-gray-600 font-bold flex"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
      </svg>
      Хэрэглэгч жагсаалт</h2>
    <div class="flex items-center space-x-1 text-xs">
      <inertia-link href="/" class="font-bold text-indigo-700 text-sm">Нүүр хуудас</inertia-link>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <span class="text-gray-600 text-sm">Хэрэглэгч</span>
    </div>
  </div>

  <div class="p-4 mt-8 sm:px-8 sm:py-4">
    <!---->

    <div class=" flex flex-wrap">
      <div class="w-full">
        <div class="flex mb-0  flex-wrap pt-3 pb-4 gap-2">

          <div v-for="role in  roles" class="">
            <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-orange-600 bg-white"
              :class="{ '!text-white bg-orange-600': form.roles == role.id }" @click="form.roles = role.id">
              {{ role.name }}
            </a>
          </div>
        </div>

      </div>
    </div>


    <!---->


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
            placeholder="Хэрэглэгч хайх" />
        </div>
      </div>
      <admin-table :headers="{
        name: 'Хэрэглэгчийн нэр',
        username: 'Нэвтрэх нэр',
        'deleted_at': 'Төлөв',
        'aimag_city.name': 'Аймаг/нийслэл',
        'soum_district.name': 'Сум/дүүрэг',
        'bag_horoo.name': 'Баг/хороо',
        roles: 'Эрх',
      }" :datas="datas" url="admin.users.edit" :insertUrl="route('admin.users.create')"
        :deleteUrl="'admin.users.destroy'" />
    </div>
    <div class="py-2 flex items-center justify-between border-t border-gray-200">
      <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"></div>
      <div class="hidden sm:flex-2 sm:flex sm:items-center sm:justify-between">
        <pagination :links="datas.links" />
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
    auth: Object,
  },
  computed: {
    openTab() {
      return 2;
    }
  },
  data() {
    return {
      form: {
        aimag_city_id: null,
        soum_district_id: null,
        bag_horoo_id: null,
        roles: null,
        ...(this.filters ? this.filters : {}),
      },
      roles: this.auth.user.roles == 'admin' || this.auth.user.roles == 'zaa' ?
        [
          { id: "admin", name: "Админ" },
          { id: "zaa", name: "Захирагчийн ажлын алба" },
          { id: "mha", name: "МХ админ" },
          { id: "mhb", name: "МХ байцаагч" },
          { id: "da", name: "Дүүргийн админ" },
          { id: "hd", name: "Хороон дарга" },
          { id: "onb", name: "Олон нийтийн байцаагч" },
          { id: "none", name: "Идэвхгүй" },
        ] :
        this.auth.user.roles == 'mha' ? [
          { id: "mha", name: "МХ админ" },
          { id: "mhb", name: "МХ байцаагч" },
          { id: "none", name: "Идэвхгүй" },
        ] :
          this.auth.user.roles == 'da' ? [
            { id: "da", name: "Дүүргийн админ" },
            { id: "hd", name: "Хороон дарга" },
            { id: "onb", name: "Олон нийтийн байцаагч" },
            { id: "none", name: "Идэвхгүй" },
          ] : []
      ,
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
