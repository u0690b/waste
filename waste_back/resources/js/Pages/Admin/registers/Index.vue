<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <h2 class="text-xl text-gray-600">Зөрчлийн бүртгэл</h2>
    <div class="flex items-center space-x-1 text-xs">
      <ILink href="/" class="font-bold text-indigo-700 text-sm">Нүүр хуудас</ILink>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <span class="text-gray-600 text-sm">Зөрчлийн бүртгэл</span>
    </div>
  </div>
  <div class="p-4 mt-8 sm:px-8 sm:py-4">
    <div class="flex flex-wrap">
      <div class="w-full">
        <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
          <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
            <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-orange-600 bg-white" @click="form.status_id = 2" :class="{ '!text-white bg-orange-600': openTab === 2 }">
              Илгээсэн
            </a>
          </li>
          <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
            <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-blue-600 bg-white" @click="form.status_id = 3" v-bind:class="{ '!text-white bg-blue-600': openTab === 3 }">
              Хуваарилсан
            </a>
          </li>
          <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
            <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal text-green-600 bg-white" @click="form.status_id = 4" v-bind:class="{ '!text-white bg-green-600': openTab === 4 }">
              Шийдвэрлэсэн
            </a>
          </li>

        </ul>
        <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
          <div class="px-4 py-5 flex-auto">
            <div class="tab-content tab-space">
              <div>
                <div class="p-4 bg-white rounded">
                  <div class="flex justify-between">
                    <div>
                      <div class="relative text-gray-400">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                          </svg>
                        </span>
                        <input id="search" name="search" type="search" v-model="form.search" class="w-full py-2 text-sm text-gray-900 rounded-md pl-10 border border-gray-300 focus:outline-none focus:ring-gray-500  focus:z-10" placeholder="Бүртгэл хайх" />
                      </div>
                    </div>

                  </div>

                  <table class="w-full mt-2 text-gray-500">
                    <thead class="border-b">
                      <tr>
                        <th class="p-2 text-left text-gray-600">
                          <input type="checkbox" class="h-5 w-5 text-blue-500 border-gray-300 rounded cursor-pointer focus:ring-0" />
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
                          <input type="checkbox" class="h-5 w-5 text-blue-500 border-gray-300 rounded cursor-pointer focus:ring-0" />
                        </td>
                        <td class="flex items-center py-4">
                          <!-- <img class="inline-block h-12 w-12 rounded-full ring-2 ring-white" alt="" /> -->
                          <div class="px-4">
                            <div>
                              <a href="#" class="text-gray-600 font-bolder">{{ data.name }}</a>
                            </div>
                            <div class="font-bold text-sm">
                              {{ data.register }}
                            </div>
                          </div>
                        </td>
                        <td>{{ data.reason?.name ?? '' }}</td>
                        <td>{{ data.status_id == 2 ? data.reg_user?.name ?? '' : data.comf_user?.name ?? '' }}</td>

                        <td>
                          <span v-if="data.status_id == 2" class="px-2 py-1 rounded text-xs text-white bg-orange-500">
                            {{ data.status?.name ?? 'хоосон' }}
                          </span>
                          <span v-if="data.status_id == 3" class="px-2 py-1 rounded text-xs text-white bg-blue-500">
                            {{ data.status?.name ?? 'хоосон' }}
                          </span>
                          <span v-if="data.status_id == 4" class="px-2 py-1 rounded text-xs text-white bg-green-500">
                            {{ data.status?.name ?? 'хоосон' }}
                          </span>
                        </td>
                        <td>{{ calcDateRange(data.reg_at, data.resolved_at) }} хоног</td>
                        <td>{{ data.created_at }}</td>
                        <td class="text-right">
                          <Menu as="div" class="relative inline-block text-left">
                            <div>
                              <MenuButton class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white rounded-md bg-gray-500 hover:bg-gray-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75 ">
                                Үйлдэл
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2 -mr-1 text-violet-200 hover:text-violet-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                              </MenuButton>
                            </div>

                            <Transition enter-active-class="transition duration-100 ease-out" enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100" leave-active-class="transition duration-75 ease-in" leave-from-class="transform scale-100 opacity-100" leave-to-class="transform scale-95 opacity-0">
                              <MenuItems class=" absolute right-0 w-32 mt-1 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50 focus:outline-none ">
                                <div class="px-1 py-1">
                                  <MenuItem v-slot="{ active }">
                                  <ILink :href="route('admin.registers.show', data.id)" :class="[active ? 'bg-gray-400 text-white' : 'text-gray-900', 'group flex rounded-md items-center w-full px-1 py-2 text-sm',]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    Дэлгэрэнгүй
                                  </ILink>
                                  </MenuItem>
                                  <MenuItem v-if="data.status_id != 4 && auth.user.roles == 'mha'" v-slot="{ active }">
                                  <ILink :href="route('admin.register.allocation', data.id)" :class="[active ? 'bg-blue-400 text-white' : 'text-gray-900', 'group flex rounded-md items-center w-full px-1 py-2 text-sm',]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Хуваарилах
                                  </ILink>
                                  </MenuItem>
                                  <MenuItem v-if="data.status_id == 3 || ['mha'].includes(auth.user.roles)" v-slot="{ active }">
                                  <ILink :href="route('admin.registers.show_resolve', data.id)" :class="[active ? 'bg-green-400 text-white' : 'text-gray-900', 'group flex rounded-md items-center w-full px-1 py-2 text-sm',]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
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
                  <div class="py-2 flex items-center justify-between border-t border-gray-200 ">
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"></div>
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
</template>

<script>
  import Layout from "@/Layouts/Admin.vue";
  import mapValues from "lodash/mapValues";
  import Pagination from "@/Components/Pagination.vue";
  import pickBy from "lodash/pickBy";
  import SearchFilter from "@/Components/SearchFilter.vue";
  import debounce from "lodash/debounce";
  import AdminTable from "@/Components/AdminTable.vue";
  import MySelect from "@/Components/MySelect.vue";
  import AdminCard from "@/Components/AdminCard.vue";
  import SharedState from "@/Components/SharedState.vue";
  import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
  import { Transition } from "vue";
  export default {
    name: "pink-tabs",
    metaInfo: { title: "Registers" },
    components: {
      Pagination,
      SearchFilter,
      AdminTable,
      MySelect,
      AdminCard,
      SharedState,
      MenuItems,
      Transition,
      Menu,
      MenuButton,
      MenuItem
    },
    layout: Layout,
    props: {
      datas: Object,
      filters: [Object, Array],
      host: String,
      auth: [Object, Array],
    },
    data() {
      return {
        form: {
          aimag_city_id: null,
          soum_district_id: null,
          bag_horoo_id: null,
          reason_id: null,
          reg_user_id: null,
          comf_user_id: null,
          status_id: null,
          ...(this.filters ? this.filters : {}),
        },
        headers: {
          name: 'Байгууллага, аж ахуйн нэгжийн нэр, иргэний овог нэр',
          register: 'Регистрийн дугаар',
          chiglel: 'Үйл ажиллагааны чиглэл',
          'aimag_city.name': 'Аймаг,Нийслэл',
          aimag_city_id: 'Аймаг,Нийслэл',
          'soum_district.name': 'Сум,Дүүрэг',
          soum_district_id: 'Сум,Дүүрэг',
          'bag_horoo.name': 'Баг,Хороо',
          bag_horoo_id: 'Баг,Хороо',
          address: 'Хаяг, байршилд',
          description: 'Гаргасан зөрчлийн байдал',
          'reason.name': 'Зөрчлийн төрөл',
          reason_id: 'Зөрчлийн төрөл',
          zuil_zaalt: 'Зөрчсөн хууль тогтоомжийн зүйл, заалт',
          resolve_desc: 'Зөрчлийг шийдвэрлэсэн байдал',
          long: 'Уртраг',
          lat: 'Өргөрөг',
          'reg_user.name': 'Бүртгэсэн хүн',
          reg_user_id: 'Бүртгэсэн хүн',
          'comf_user.name': 'Шийдвэрлэсэн хүн',
          comf_user_id: 'Шийдвэрлэсэн хүн',
          'status.name': 'Төлөв',
          status_id: 'Төлөв',
        },
      };
    },
    watch: {
      form: {
        handler: debounce(function () {
          this.$inertia.get(this.route("admin.registers.index"), pickBy(this.form), {
            preserveState: true,
          });
        }, 150),
        deep: true,
      },
    },
    computed: {
      openTab() {
        return parseInt(this.form.status_id) ?? 2;
      }
    },
    methods: {
      reset() {
        this.form = mapValues(this.form, () => null);
      },
      calcDateRange(start, end) {
        let difference = (isNaN(Date.parse(end)) ? Date.now() : Date.parse(end)) - Date.parse(start);
        return (isNaN(difference) ? '~' : Math.ceil(difference / (1000 * 3600 * 24)));
      }

    },
  };

</script>
