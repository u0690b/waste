<template>
    <Layout :title="title">
        <div class="p-4 mt-8 sm:px-8 sm:py-4">
            <div class="p-4 bg-white rounded shadow">
                <h1 class="pb-4 mb-6 text-xl font-bold border-b">{{ title }}</h1>
                <PaginationFilter v-model="form.model.per_page" @update:model-value="() => form.model.page = 1"
                    v-model:search="form.model.search" :total="datas.total" />
                <AdminTable :headers="headers" :datas="datas" url="/admin/reasons" @order-by="(v) => orderBy(form, v)">
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

const title = 'Шалтгаан жагсаалт'

const headers = [
    { key: 'code', name: 'код', order: 'code' },
    { key: 'name', name: 'Шалтгаан', order: 'name' },
    { key: 'sub_group', name: 'Дэд бүлэг', order: 'sub_group' },
    // { key: 'stype', name: 'Төрөл', order: 'stype' },
    { key: 'place.name', name: 'Хариуцах нэгж', order: 'place_id', url: '/admin/places' }
]

const form = useForm({ model: { ...props.filters, per_page: props.datas.per_page } })
    .transform(data => data.model)

watch(() => form.model, debounce(() => form.get('', { preserveState: true }), 150), { deep: true })

</script>
