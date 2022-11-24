<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Register Histories</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <my-select v-model="form.register_id" label="Register Id" :url="`${host}/registers`" />
        <my-select v-model="form.reason_id" label="Reason Id" :url="`${host}/reasons`" />
        <my-select v-model="form.status_id" label="Status Id" :url="`${host}/statuses`" />
        <my-select v-model="form.aimag_city_id" label="Aimag City Id" :url="`${host}/aimag_cities`" />
        <my-select v-model="form.soum_district_id" label="Soum District Id" :url="`${host}/soum_districts`" />
        <my-select v-model="form.bag_horoo_id" label="Bag Horoo Id" :url="`${host}/bag_horoos`" />
        <my-select v-model="form.user_id" label="User Id" :url="`${host}/users`" />
      </search-filter>
      <inertia-link class="btn-indigo" :href="route('admin.register_histories.create')">
        <span>Create</span>
        <span class="hidden md:inline">Register Histories</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <admin-table :headers="['register.name','register_id','long','lat','description','resolve_desc','reason.name','reason_id','status.name','status_id','aimag_city.name','aimag_city_id','soum_district.name','soum_district_id','bag_horoo.name','bag_horoo_id','address','user.name','user_id']" :datas="datas" url="admin.register_histories.edit"/>
      
    </div>
    <pagination :links="datas.links" />
  </div>
</template>

<script>
import Layout from '@/Layouts/Admin'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Components/Pagination'
import pickBy from 'lodash/pickBy'
import SearchFilter from '@/Components/SearchFilter'
import debounce from 'lodash/debounce'
import AdminTable from '@/Components/AdminTable.vue'
import MySelect from '@/Components/MySelect'
export default {
  metaInfo: { title: 'Register Histories' },
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
        register_id: null,
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
        this.$inertia.get(this.route('admin.register_histories.index'), pickBy(this.form), { preserveState: true })
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