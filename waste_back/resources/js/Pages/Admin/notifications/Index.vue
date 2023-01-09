<template>
  <div class="container p-8">
    <h1 class="mb-8 font-bold text-3xl">Мэдээлэл</h1>

    <div class="bg-white rounded shadow mb-8">

      <table class="w-full mt-2 text-gray-500">
        <thead class="border-b uppercase">
          <tr class="font-bold text-left">
            <th class="pl-2 w-11"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
              </svg>
            </th>
            <th v-for="(header, i) in Object.values(headers)" :key="i" class="text-gray-600"
              @click="$emit('orderBy', i)">
              {{ header }}
            </th>

          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, index) in datas.data" :key="row.id" class="hover:bg-gray-300 focus-within:bg-gray-300"
            :class="{ 'font-bold bg-gray-100': !row.read_at }">
            <td class="pl-2 border-t ">{{ index + 1 }}</td>
            <td v-for="(key, i) in Object.keys(headers)" :key="i" class="px-2 py-2 border-t">

              <span class="items-center">{{ row[key] }}</span>
            </td>

          </tr>
          <tr v-if="datas.length === 0">
            <td class="px-6 py-4 border-t" colspan="4">Мэдээлэл байхгүй</td>
          </tr>
        </tbody>

      </table>
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
  metaInfo: { title: 'Мэдээлэл' },
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
        user_id: null,
        ...this.filters ? this.filters : {},
      },
      headers: { 'type': 'Төрөл', 'title': 'Гарчиг', 'content': 'Агуулга', 'created_at': 'Ирсэн' }
    }
  },
  watch: {
    form: {
      handler: debounce(function () {
        this.$inertia.get(this.route('admin.notifications.index'), pickBy(this.form), { preserveState: true })
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