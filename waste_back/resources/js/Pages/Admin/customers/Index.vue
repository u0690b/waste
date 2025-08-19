<template>
  <Layout :title="title">
    <div class="p-4 mt-8 sm:px-8 sm:py-4">
      <div class="p-4 bg-white rounded shadow">
        <h1 class="pb-4 mb-6 text-xl font-bold border-b">{{ title }}</h1>
        <PaginationFilter v-model="form.model.per_page" @update="() => form.model.page = 1"  v-model:search="form.model.search" @update="() => form.model.page = 1" :total="datas.total" />
        <AdminTable :headers="headers" :datas="datas" url="/admin/customers" @order-by="(v) => orderBy(form, v)">
          <template #filter>
             <AdminTableFilter v-model:model="form.model" :headers="headers" />
          </template>
        </AdminTable>
        <Pagination :links="datas.links" />
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from '@/Layouts/Admin.vue'
import Pagination from '@/Components/Pagination.vue'
import AdminTable from '@/Components/AdminTable.vue'
import AdminTableFilter from '@/Components/AdminTableFilter.vue'
import { useForm } from '@inertiajs/vue3'
import { watch } from 'vue'
import PaginationFilter from '@/Components/PaginationFilter.vue'
import { debounce } from '@/utils/useDebouncedRef'
import orderBy from '@/utils/orderBy'
import MySelect from '@/Components/MySelect.vue'
import MyInput from '@/Components/MyInput.vue'

const props = defineProps({
  datas: Object,
  filters: { type: Object, default: () => ({ search: '' }) },
});

const title = 'Customers жагсаалт'

const headers = [
  { key: 'regnum', name: '', order: 'regnum' },
  { key: 'firstname', name: '', order: 'firstname' },
  { key: 'gender', name: '', order: 'gender' },
  { key: 'image', name: '', order: 'image' },
  { key: 'lastname', name: '', order: 'lastname' },
  { key: 'nationality', name: '', order: 'nationality' },
  { key: 'passportAddress', name: '', order: 'passportAddress' },
  { key: 'passportExpireDate', name: '', order: 'passportExpireDate' },
  { key: 'passportIssueDate', name: '', order: 'passportIssueDate' },
  { key: 'soumDistrictCode', name: '', order: 'soumDistrictCode' },
  { key: 'soumDistrictName', name: '', order: 'soumDistrictName' },
  { key: 'surname', name: '', order: 'surname' },
  { key: 'token', name: '', order: 'token' },
  { key: 'remember_token', name: '', order: 'remember_token' },
  { key: 'push_token', name: '', order: 'push_token' }
]

const form = useForm({ model: { ...props.filters, per_page: props.datas.per_page } })
  .transform(data => data.model)

watch(() => form.model, debounce(() => form.get('', { preserveState: true }), 150), { deep: true })

</script>
