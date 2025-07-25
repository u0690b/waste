<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Attached Files</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <MySelect v-model="form.register_id" label="Зөрчлийн Бүртгэл" :url="`/admin/registers`" />
      </search-filter>
      <ILink class="btn-indigo" :href="route('admin.attached_files.create')">
        <span>Create</span>
        <span class="hidden md:inline">Attached Files</span>
      </ILink>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <admin-table :headers="{ 'register.name': 'Зөрчлийн бүртгэл', 'register_id': 'Зөрчлийн бүртгэл', 'path': 'файлын зам', 'type': 'Төрөл' }" :datas="datas" url="admin.attached_files.edit" />

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
    metaInfo: { title: 'Attached Files' },
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
          register_id: null,
          ...this.filters ? this.filters : {},
        },
      }
    },
    watch: {
      form: {
        handler: debounce(function () {
          this.$inertia.get(this.route('admin.attached_files.index'), pickBy(this.form), { preserveState: true })
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