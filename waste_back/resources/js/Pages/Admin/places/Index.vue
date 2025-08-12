<template>
    <Layout :title="title">
        <div class="p-4 mt-8 sm:px-8 sm:py-4">
            <div class="p-4 bg-white rounded shadow">
                <h1 class="pb-4 mb-6 text-xl font-bold border-b">{{ title }}</h1>
                <PaginationFilter v-model="form.model.per_page" v-model:search="form.model.search"
                    :total="datas.total" />
                <AdminTable :headers="headers" :datas="datas" url="/admin/places" @order-by="(v) => orderBy(form, v)">
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
import AdminTable from '@/Components/AdminTable1.vue'
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

const title = 'Хариуцах нэгж'

const headers = [
    { key: 'name', name: 'Газрын нэр', order: 'name' }
]

const form = useForm({ model: { ...props.filters, per_page: props.datas.per_page } })
    .transform(data => data.model)

watch(() => form.model, debounce(() => form.get('', { preserveState: true }), 150), { deep: true })

</script>
