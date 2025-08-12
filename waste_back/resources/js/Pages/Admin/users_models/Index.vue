<template>
    <Layout :title="title">
        <div class="px-4 ">
            <div class="flex flex-wrap ">
                <div class="w-full">
                    <div class="flex flex-wrap gap-2 pt-3 pb-4 mb-0">

                        <div v-for="role in roles" class="">
                            <a class="block px-5 py-3 text-xs font-bold leading-normal text-[#406f47] uppercase bg-white rounded shadow-lg"
                                :class="{ '!text-white !bg-[#406f47]': form.model.roles == role.id }"
                                @click="form.model.roles = role.id">
                                {{ role.name }}
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="p-4 bg-white rounded shadow">
                <h1 class="pb-4 mb-6 text-xl font-bold border-b">{{ title }}</h1>

                <PaginationFilter v-model="form.model.per_page" @update="() => form.model.page = 1"
                    v-model:search="form.model.search" :total="datas.total" />
                <AdminTable :headers="headers" :datas="datas" url="/admin/users" nodelete
                    @order-by="(v) => orderBy(form, v)">
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
import { useForm, usePage } from '@inertiajs/vue3'
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

const title = 'Хэрэглэгч жагсаалт'

const headers = [
    { key: 'name', name: 'Нэр', order: 'name', filter: true },
    { key: 'username', name: 'Нэвтрэх нэр', order: 'username', filter: true },
    { key: 'aimag_city.name', name: 'Айман/нийслэл', order: 'aimag_city_id', url: '/admin/aimag_cities', filter: true },
    { key: 'soum_district.name', name: 'Сум/Дүүрэг', order: 'soum_district_id', url: '/admin/soum_districts', filter: true },
    { key: 'bag_horoo.name', name: 'Баг хороо', order: 'bag_horoo_id', url: '/admin/bag_horoos', filter: true },
    { key: 'phone', name: 'Утас', order: 'phone', filter: true },
    { key: 'place.name', name: 'Харьялах нэгж', order: 'place_id', url: '/admin/places', filter: true },
    // { key: 'roles', name: 'Эхийн түвшин', order: 'roles', filter: true },
]


const auth = usePage().props.auth;
const roles = auth.user.roles == 'admin' ?
    [
        { id: "admin", name: "Админ" },
        { id: "da", name: "Аймаг, дүүрэг" },
        { id: "mha", name: "БОХУБ" },
    ] :
    auth.user.roles == 'da' ? [
        { id: "mha", name: "БОХУБ" },
    ] : []


const form = useForm({ model: { ...props.filters, per_page: props.datas.per_page } })
    .transform(data => data.model)

watch(() => form.model, debounce(() => form.get('', { preserveState: true }), 150), { deep: true })

</script>
