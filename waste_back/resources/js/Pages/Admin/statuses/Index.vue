<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Statuses</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">

      </search-filter>
      <inertia-link class="btn-indigo" :href="route('admin.statuses.create')">
        <span>Create</span>
        <span class="hidden md:inline">Statuses</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <admin-table :headers="['name']" :datas="datas" url="admin.statuses.edit"/>
      
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

export default {
  metaInfo: { title: 'Statuses' },
  components: {
    Pagination,
    SearchFilter,
    AdminTable,
    
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
        
        ...this.filters?this.filters:{},
      },
    }
  },
  watch: {
    form: {
      handler: debounce(function() {
        this.$inertia.get(this.route('admin.statuses.index'), pickBy(this.form), { preserveState: true })
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