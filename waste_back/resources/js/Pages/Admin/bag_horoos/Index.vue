<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Bag Horoos</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <MySelect v-model="form.soum_district_id" label="Сум,Дүүрэг" :url="`/admin/soum_districts`" />
      </search-filter>
      <inertia-link class="btn-indigo" :href="route('admin.bag_horoos.create')">
        <span>Create</span>
        <span class="hidden md:inline">Bag Horoos</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <admin-table :headers="{'code':'Код','name':'Баг,Хороо','soum_district.name':'Сум,Дүүрэг','soum_district_id':'Сум,Дүүрэг'}" :datas="datas" url="admin.bag_horoos.edit"/>
      
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
  metaInfo: { title: 'Bag Horoos' },
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
        soum_district_id: null,
        ...this.filters?this.filters:{},
      },
    }
  },
  watch: {
    form: {
      handler: debounce(function() {
        this.$inertia.get(this.route('admin.bag_horoos.index'), pickBy(this.form), { preserveState: true })
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