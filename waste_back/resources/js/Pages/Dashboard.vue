<script setup>
import AdminTable from "@/Components/AdminTable.vue";
import MySelect from "@/Components/MySelect.vue";
import Pagination from "@/Components/Pagination.vue";
import SearchFilter from "@/Components/SearchFilter.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { Head } from "@inertiajs/inertia-vue3";
import debounce from "lodash/debounce";
import mapValues from "lodash/mapValues";
import pickBy from "lodash/pickBy";
import { reactive, watch } from "vue";

const props = defineProps({
  datas: Object,
  filters: [Object, Array],
  host: String,
});
let form = reactive({});
const reset = () => (form = mapValues(form, () => null));

watch(
  () => form,
  debounce(function () {
    Inertia.get("/", pickBy(form), { preserveState: true });
  }, 150),
  { deep: true }
);
const tableHeader = {
  long: "Уртраг",
  lat: "Өргөрөг",
  description: "Тайлбар",
  resolve_desc: "Тэмдэглэл",
  "reason.name": "Шалтгаан",
  reason_id: "Шалтгаан",
  "status.name": "Төлөв",
  status_id: "Төлөв",
  "aimag_city.name": "Аймаг,Нийслэл",
  aimag_city_id: "Аймаг,Нийслэл",
  "soum_district.name": "Сум,Дүүрэг",
  soum_district_id: "Сум,Дүүрэг",
  "bag_horoo.name": "Баг,Хороо",
  bag_horoo_id: "Баг,Хороо",
  address: "Хаяг",
  "user.name": "Бүртгэсэн хүн",
  user_id: "Бүртгэсэн хүн",
};
</script>

<template>
  <Head title="Үндсэн хуудас" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Үндсэн хуудас</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white max-w-3x shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <h1 class="mb-8 font-bold text-3xl">Хог хаягдлын бүртгэл</h1>
            <div class="mb-6 flex justify-between items-center">
              <SearchFilter
                v-model="form.search"
                class="w-full max-w-md mr-4"
                @reset="reset"
              >
                <MySelect
                  v-model="form.reason_id"
                  label="Шалтгаан"
                  :url="`/admin/reasons`"
                />
                <MySelect
                  v-model="form.status_id"
                  label="Төлөв"
                  :url="`/admin/statuses`"
                />
                <MySelect
                  v-model="form.aimag_city_id"
                  label="Аймаг,Нийслэл"
                  :url="`/admin/aimag_cities`"
                />
                <MySelect
                  v-model="form.soum_district_id"
                  label="Сум,Дүүрэг"
                  :url="`/admin/soum_districts`"
                />
                <MySelect
                  v-model="form.bag_horoo_id"
                  label="Баг,Хороо"
                  :url="`/admin/bag_horoos`"
                />
                <MySelect
                  v-model="form.user_id"
                  label="Бүртгэсэн Хүн"
                  :url="`/admin/users`"
                />
              </SearchFilter>
            </div>
            <div class="bg-white rounded shadow">
              <AdminTable
                :headers="tableHeader"
                :datas="datas"
                url="admin.registers.edit"
              />
            </div>
            <Pagination :links="datas.links" />
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
