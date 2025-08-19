<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head,  useForm } from '@inertiajs/vue3';
import { Header, NotificationModel, PaginatedData } from '@/types/type';
import { watch } from 'vue';
import { useDebounceFn } from '@vueuse/core';
import AdminTable from '@/components/My/AdminTable.vue';
import useOrderBy from '@/composables/useOrder';
import PaginationFilter from '@/components/My/PaginationFilter.vue';
import Pagination from '@/components/My/Pagination.vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Дашбоард',
        href: '',
    },
    {
        title: 'Мэдэгдэл',
        href: 'notifications',
    },
];

const props = defineProps<{
    datas: PaginatedData <NotificationModel> ,
    filters: { search: string, page :number},
}>()

const headers: Header[] = [
    // { key: 'user.name', name: 'Хэнээс', order: 'user_id', url: '/admin/users' },
    // { key: 'type', name: 'Төрөл', order: 'type' },
    { key: 'title', name: 'Гарчиг', order: 'title' },
    { key: 'content', name: 'Агуулга', order: 'content' },
]

const form = useForm({ model: { ...props.filters, per_page: props.datas.per_page } })
    .transform(data => data.model)

watch(() => form.model, useDebounceFn(() => form.get('', { preserveState: true }), 150), { deep: true })
</script>

<template>

    <Head title="Мэдэгдэл" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mt-8 px-2 grid gap-2">
            <UCard>
                <PaginationFilter v-model="form.model.per_page" @update="() => form.model.page = 1"
                    v-model:search="form.model.search" :total="datas.total" />
                <AdminTable :headers="headers" :datas="datas" @order-by="(v) => useOrderBy(form, v)">

                </AdminTable>
                <UPagination v-model:page="form.model.page" active-color="primary" :total="datas.total" />
            </UCard>
        </div>
    </AppLayout>

</template>
