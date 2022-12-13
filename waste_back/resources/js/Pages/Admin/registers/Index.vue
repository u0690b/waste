<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Registers</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <MySelect v-model="form.aimag_city_id" label="Аймаг,Нийслэл" :url="`/admin/aimag_cities`" />
        <MySelect v-model="form.soum_district_id" label="Сум,Дүүрэг" :url="`/admin/soum_districts`" />
        <MySelect v-model="form.bag_horoo_id" label="Баг,Хороо" :url="`/admin/bag_horoos`" />
        <MySelect v-model="form.reason_id" label="Зөрчилийн Төрөл" :url="`/admin/reasons`" />
        <MySelect v-model="form.reg_user_id" label="Бүртгэсэн Хүн" :url="`/admin/reg_users`" />
        <MySelect v-model="form.comf_user_id" label="Шийдвэрлэсэн Хүн" :url="`/admin/comf_users`" />
        <MySelect v-model="form.status_id" label="Төлөв" :url="`/admin/statuses`" />
      </search-filter>
      <inertia-link class="btn-indigo" :href="route('admin.registers.create')">
        <span>Create</span>
        <span class="hidden md:inline">Registers</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <admin-table :headers="{'name':'Байгууллага, аж ахуйн нэгжийн нэр, иргэний овог нэр','register':'Регистрийн дугаар','chiglel':'Үйл ажиллагааны чиглэл','aimag_city.name':'Аймаг,Нийслэл','aimag_city_id':'Аймаг,Нийслэл','soum_district.name':'Сум,Дүүрэг','soum_district_id':'Сум,Дүүрэг','bag_horoo.name':'Баг,Хороо','bag_horoo_id':'Баг,Хороо','address':'Хаяг, байршилд','description':'Гаргасан зөрчилийн байдал','reason.name':'Зөрчилийн төрөл','reason_id':'Зөрчилийн төрөл','zuil_zaalt':'Зөрчсөн хууль тогтоомжийн зүйл, заалт','resolve_desc':'Зөрчлийг шийдвэрлэсэн байдал','long':'Уртраг','lat':'Өргөрөг','reg_user.name':'Бүртгэсэн хүн','reg_user_id':'Бүртгэсэн хүн','comf_user.name':'Шийдвэрлэсэн хүн','comf_user_id':'Шийдвэрлэсэн хүн','status.name':'Төлөв','status_id':'Төлөв'}" :datas="datas" url="admin.registers.edit"/>
      
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
        aimag_city_id: null,
        soum_district_id: null,
        bag_horoo_id: null,
        reason_id: null,
        reg_user_id: null,
        comf_user_id: null,
        status_id: null,
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