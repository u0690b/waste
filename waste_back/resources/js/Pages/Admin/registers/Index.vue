<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Registers</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <MySelect v-model="form.reason_id" label="Шалтгаан" :url="`/admin/reasons`" />
        <MySelect v-model="form.status_id" label="Төлөв" :url="`/admin/statuses`" />
        <MySelect v-model="form.aimag_city_id" label="Аймаг,Нийслэл" :url="`/admin/aimag_cities`" />
        <MySelect v-model="form.soum_district_id" label="Сум,Дүүрэг" :url="`/admin/soum_districts`" />
        <MySelect v-model="form.bag_horoo_id" label="Баг,Хороо" :url="`/admin/bag_horoos`" />
        <MySelect v-model="form.user_id" label="Бүртгэсэн Хүн" :url="`/admin/users`" />
      </search-filter>
      <inertia-link class="btn-indigo" :href="route('admin.registers.create')">
        <span>Create</span>
        <span class="hidden md:inline">Registers</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <admin-table :headers="{'long':'Уртраг','lat':'Өргөрөг','description':'Тайлбар','resolve_desc':'Тэмдэглэл','reason.name':'Шалтгаан','reason_id':'Шалтгаан','status.name':'Төлөв','status_id':'Төлөв','aimag_city.name':'Аймаг,Нийслэл','aimag_city_id':'Аймаг,Нийслэл','soum_district.name':'Сум,Дүүрэг','soum_district_id':'Сум,Дүүрэг','bag_horoo.name':'Баг,Хороо','bag_horoo_id':'Баг,Хороо','address':'Хаяг','user.name':'Бүртгэсэн хүн','user_id':'Бүртгэсэн хүн'}" :datas="datas" url="admin.registers.edit"/>
      
    </div>
    <pagination :links="datas.links" />
  </div>
</template>

<script>
import Layout from '@/Layouts/Admin.vue'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Components/Pagination.vue'
import pickBy from 'lodash/pickBy'
import SearchFilter from '@/Components/SearchFilter.vue'
import debounce from 'lodash/debounce'
import AdminTable from '@/Components/AdminTable.vue'
import MySelect from '@/Components/MySelect.vue'
export default {
  metaInfo: { title: 'Registers' },
  components: {
    Pagination,
    SearchFilter,
    AdminTable,
    MySelect,
  },
  layout: Layout,
  props: {
    datas: Object,
    filters: [Object,Array],
    host: String,
  },
  data() {
    return {
      form: {
        reason_id: null,
        status_id: null,
        aimag_city_id: null,
        soum_district_id: null,
        bag_horoo_id: null,
        user_id: null,
        ...this.filters?this.filters:{},
      },
    }
  },
  watch: {
    form: {
      handler: debounce(function() {
        this.$inertia.get(this.route('admin.registers.index'), pickBy(this.form), { preserveState: true })
      }, 150),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>