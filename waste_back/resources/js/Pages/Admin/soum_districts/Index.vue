<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Soum Districts</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <MySelect v-model="form.aimag_city_id" label="Аймаг/Нийслэл" :url="`/admin/aimag_cities`" />
      </search-filter>
      <inertia-link class="btn-indigo" :href="route('admin.soum_districts.create')">
        <span>Create</span>
        <span class="hidden md:inline">Soum Districts</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <admin-table :headers="{'code':'Код','name':'Аймаг нэр','aimag_city.name':'Аймаг/Нийслэл','aimag_city_id':'Аймаг/Нийслэл'}" :datas="datas" url="admin.soum_districts.edit"/>
      
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
  metaInfo: { title: 'Soum Districts' },
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
        ...this.filters?this.filters:{},
      },
    }
  },
  watch: {
    form: {
      handler: debounce(function() {
        this.$inertia.get(this.route('admin.soum_districts.index'), pickBy(this.form), { preserveState: true })
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