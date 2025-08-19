<template>
    <Layout>
        <div class="flex justify-between px-4 mt-4 sm:px-8">
            <h2 class="text-xl text-gray-600">Зөрчлийн бүртгэл</h2>
            <div class="flex items-center space-x-1 text-xs">
                <ILink href="/" class="text-sm font-bold text-indigo-700">Нүүр хуудас</ILink>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-2 h-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-sm text-gray-600">Зөрчлийн бүртгэл</span>
            </div>
        </div>
        <div class="p-4 mt-8 sm:px-8 sm:py-4">
            <div class="flex flex-wrap">
                <div class="w-full">
                    <ul class="flex flex-row flex-wrap pt-3 pb-4 mb-0 list-none">
                        <li class="flex-auto mr-2 -mb-px text-center last:mr-0">
                            <a class="block px-5 py-3 text-xs font-bold leading-normal text-orange-600 uppercase bg-white rounded shadow-lg"
                                @click="form.model.status_id = 2"
                                :class="{ '!text-white !bg-orange-600': openTab === 2 }">
                                Илгээсэн
                            </a>
                        </li>
                        <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                            <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-blue-600 bg-white"
                                @click="form.model.status_id = 3"
                                v-bind:class="{ '!text-white !bg-blue-600': openTab === 3 }">
                                Шилжүүлсэн
                            </a>
                        </li>
                        <li class="flex-auto mr-2 -mb-px text-center last:mr-0">
                            <a class="block px-5 py-3 text-xs font-bold leading-normal text-green-600 uppercase bg-white rounded shadow-lg"
                                @click="form.model.status_id = 4"
                                v-bind:class="{ '!text-white !bg-green-600': openTab === 4 }">
                                Шийдвэрлэсэн
                            </a>
                        </li>

                    </ul>
                    <div class="relative flex flex-col w-full min-w-0 mb-6 break-words bg-white rounded shadow-lg">
                        <div class="flex-auto px-4 py-5">
                            <div class="tab-content tab-space">
                                <div>
                                    <div class="p-4 bg-white rounded">
                                        <div class="flex justify-between">
                                            <div>
                                                <div class="relative text-gray-400">
                                                    <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                        </svg>
                                                    </span>
                                                    <input id="search" name="search" type="search" v-model="form.search"
                                                        class="w-full py-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-md focus:outline-none focus:ring-gray-500 focus:z-10"
                                                        placeholder="Бүртгэл хайх" />
                                                </div>
                                            </div>

                                        </div>

                                        <table class="w-full mt-2 text-gray-500">
                                            <thead class="border-b">
                                                <tr>
                                                    <th class="p-2 text-left text-gray-600">
                                                        <input type="checkbox"
                                                            class="w-5 h-5 text-blue-500 border-gray-300 rounded cursor-pointer focus:ring-0" />
                                                    </th>
                                                    <th class="text-left text-gray-600">ЗӨРЧЛИЙН МЭДЭЭЛЭЛ</th>
                                                    <th class="text-left text-gray-600">ЗӨРЧЛИЙН ТӨРӨЛ</th>
                                                    <th class="text-left text-gray-600">ХЭРЭГЛЭГЧ</th>
                                                    <th class="text-left text-gray-600">ТӨЛӨВ</th>
                                                    <th class="text-left text-gray-600">ЗАРЦУУЛСАН ХУГАЦАА</th>
                                                    <th class="text-left text-gray-600">БҮРТГЭСЭН ОГНОО</th>
                                                    <th class="text-right text-gray-600">ҮЙЛДЛҮҮД</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                <tr v-for="data in datas.data">
                                                    <td class="p-2">
                                                        <input type="checkbox"
                                                            class="w-5 h-5 text-blue-500 border-gray-300 rounded cursor-pointer focus:ring-0" />
                                                    </td>
                                                    <td class="flex items-center py-4">
                                                        <!-- <img class="inline-block w-12 h-12 rounded-full ring-2 ring-white" alt="" /> -->
                                                        <div class="px-4">
                                                            <div>
                                                                <a href="#" class="text-gray-600 font-bolder">{{
                                                                    data.name
                                                                }}</a>
                                                            </div>
                                                            <div class="text-sm font-bold">
                                                                {{ data.register }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ data.reason?.name ?? '' }}</td>
                                                    <td>{{ data.status_id == 2 ? data.reg_user?.name ?? '' :
                                                        data.comf_user?.name ?? '' }}</td>

                                                    <td>
                                                        <span v-if="data.status_id == 2"
                                                            class="px-2 py-1 text-xs text-white bg-orange-500 rounded">
                                                            {{ data.status?.name ?? 'хоосон' }}
                                                        </span>
                                                        <span v-if="data.status_id == 3"
                                                            class="px-2 py-1 text-xs text-white bg-green-500 rounded">
                                                            {{ data.status?.name ?? 'хоосон' }}
                                                        </span>
                                                        <span v-if="data.status_id == 4"
                                                            class="px-2 py-1 text-xs text-white bg-blue-500 rounded">
                                                            {{ data.status?.name ?? 'хоосон' }}
                                                        </span>
                                                    </td>
                                                    <td>{{ calcDateRange(data.created_at, data.resolved_at) }} </td>
                                                    <td>{{ data.created_at }}</td>
                                                    <td class="text-right">
                                                        <Menu as="div" class="relative inline-block text-left">
                                                            <div>
                                                                <MenuButton
                                                                    class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-gray-500 rounded-md hover:bg-gray-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75 ">
                                                                    Үйлдэл
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="w-5 h-5 ml-2 -mr-1 text-violet-200 hover:text-violet-100"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M19 9l-7 7-7-7" />
                                                                    </svg>
                                                                </MenuButton>
                                                            </div>

                                                            <Transition
                                                                enter-active-class="transition duration-100 ease-out"
                                                                enter-from-class="transform scale-95 opacity-0"
                                                                enter-to-class="transform scale-100 opacity-100"
                                                                leave-active-class="transition duration-75 ease-in"
                                                                leave-from-class="transform scale-100 opacity-100"
                                                                leave-to-class="transform scale-95 opacity-0">
                                                                <MenuItems
                                                                    class="absolute right-0 z-50 w-32 mt-1 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                                    <div class="px-1 py-1">
                                                                        <MenuItem v-slot="{ active }">
                                                                        <ILink
                                                                            :href="route('admin.registers.show', data.id)"
                                                                            :class="[active ? 'bg-gray-400 text-white' : 'text-gray-900', 'group flex rounded-md items-center w-full px-1 py-2 text-sm',]">
                                                                            <i
                                                                                class="ti ti-book  text-gray-500 font-bold  mr-2" />
                                                                            Дэлгэрэнгүй
                                                                        </ILink>
                                                                        </MenuItem>

                                                                        <MenuItem
                                                                            v-if="data.status_id != 4 && auth.user.roles == 'da'"
                                                                            v-slot="{ active }">
                                                                        <ILink
                                                                            :href="route('admin.register.allocation', data.id)"
                                                                            :class="[active ? 'bg-blue-400 text-white' : 'text-gray-900', 'group flex rounded-md items-center w-full px-1 py-2 text-sm',]">
                                                                            <i
                                                                                class="ti ti-direction-alt  text-gray-500 font-bold  mr-2" />
                                                                            Шилжүүлсэн
                                                                        </ILink>
                                                                        </MenuItem>
                                                                        <MenuItem v-if="data.status_id != 4"
                                                                            v-slot="{ active }">
                                                                        <ILink
                                                                            :href="route('admin.registers.show_resolve', data.id)"
                                                                            :class="[active ? 'bg-green-400 text-white' : 'text-gray-900', 'group flex rounded-md items-center w-full px-1 py-2 text-sm',]">
                                                                            <i
                                                                                class="ti ti-stamp  text-gray-500 font-bold  mr-2" />
                                                                            Шийдвэрлэх
                                                                        </ILink>
                                                                        </MenuItem>
                                                                    </div>
                                                                </MenuItems>
                                                            </Transition>
                                                        </Menu>
                                                    </td>
                                                </tr>
                                            </tbody>

                                        </table>
                                        <div class="flex items-center justify-between py-2 border-t border-gray-200 ">
                                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                            </div>
                                            <div class="hidden sm:flex-2 sm:flex sm:items-center sm:justify-between">
                                                <pagination :links="datas.links" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>




        </div>
        <!-- <div>
eaders" :datas="datas"></AdminCard>
      </div> -->
        <!-- <admin-table :headers="headers" :datas="datas" url="admin.registers.edit" /> -->
    </Layout>
</template>

<script setup>
import Layout from "@/Layouts/Admin.vue";
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
import { computed } from 'vue'
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { Transition } from "vue";
const props = defineProps({
    datas: Object,
    host: String,
    auth: [Object, Array],
    filters: { type: Object, default: () => ({ search: '' }) },
});

const title = 'Registers жагсаалт'


const headers = [
    { key: 'name', name: 'Байгууллага, аж ахуйн нэгжийн нэр, иргэний овог нэр', order: 'name' },
    { key: 'register', name: 'Регистрийн дугаар', order: 'register' },
    { key: 'chiglel', name: 'Үйл ажиллагааны чиглэл', order: 'chiglel' },
    { key: 'aimag_city.name', name: 'Аймаг,Нийслэл', order: 'aimag_city_id', url: '/admin/aimag_cities' },
    { key: 'soum_district.name', name: 'Сум,Дүүрэг', order: 'soum_district_id', url: '/admin/soum_districts' },
    { key: 'bag_horoo.name', name: 'Баг,Хороо', order: 'bag_horoo_id', url: '/admin/bag_horoos' },
    { key: 'address', name: 'Хаяг, байршилд', order: 'address' },
    { key: 'description', name: 'Гаргасан зөрчлийн байдал', order: 'description' },
    { key: 'reason.name', name: 'Зөрчлийн төрөл', order: 'reason_id', url: '/admin/reasons' },
    { key: 'zuil_zaalt', name: 'Зөрчсөн хууль тогтоомжийн зүйл, заалт', order: 'zuil_zaalt' },
    { key: 'reg_user.name', name: 'Бүртгэсэн хүн', order: 'reg_user_id', url: '/admin/reg_users' },
    { key: 'resolve.name', name: 'Шийдвэрийн төрөл', order: 'resolve_id', url: '/admin/resolves' },
    { key: 'resolve_desc', name: 'Шийдвэрлэсэн байдал', order: 'resolve_desc' },
    { key: 'resolve_image', name: 'Шийдвэрлэсэн зураг', order: 'resolve_image' },
    { key: 'resolved_at', name: 'Шийдвэрлэсэн огноо', order: 'resolved_at' },
    { key: 'comf_user.name', name: 'Шийдвэрлэсэн хүн', order: 'comf_user_id', url: '/admin/comf_users' },
    { key: 'status.name', name: 'Төлөв', order: 'status_id', url: '/admin/statuses' },
    { key: 'reg_at', name: 'Үүсгэсэн', order: 'reg_at' },
    { key: 'allocate_by', name: 'Хуваарилсан хүн', order: 'allocate_by' }
]

const form = useForm({ model: { ...props.filters, per_page: props.datas.per_page } })
    .transform(data => data.model)

watch(() => form.model, debounce(() => form.get('', { preserveState: true }), 150), { deep: true })

const openTab = computed(() => {
    return parseInt(form.model_id) ?? 2;
})


const calcDateRange = (start, end) => {
    let difference = (isNaN(Date.parse(end))) ? Date.parse((new Date()).toString()) - Date.parse(start) : Date.parse(end) - Date.parse(start);
    return (isNaN(difference) ? '~' : Math.ceil(difference / (1000 * 3600 * 24))) + ' хоног';
}
</script>
