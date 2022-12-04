<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.registers.index')">Registers</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded shadow  max-w-3x max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <number-input v-model="form.long" type="number" :error="errors.long" class="pr-6 pb-8 w-full lg:w-1/2" label="Уртраг" />
          <number-input v-model="form.lat" type="number" :error="errors.lat" class="pr-6 pb-8 w-full lg:w-1/2" label="Өргөрөг" />
          <MyInput v-model="form.description" type="text" :error="errors.description" class="pr-6 pb-8 w-full lg:w-1/2" label="Тайлбар" />
          <MyInput v-model="form.resolve_desc" type="text" :error="errors.resolve_desc" class="pr-6 pb-8 w-full lg:w-1/2" label="Тэмдэглэл" />
          <MySelect :value="null" type="text" :error="errors.reason_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Шалтгаан" :url="`/admin/reasons`" @changeId="id=>form.reason_id=id" />
          <MySelect :value="null" type="text" :error="errors.status_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Төлөв" :url="`/admin/statuses`" @changeId="id=>form.status_id=id" />
          <MySelect :value="null" type="text" :error="errors.aimag_city_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Аймаг,Нийслэл" :url="`/admin/aimag_cities`" @changeId="id=>form.aimag_city_id=id" />
          <MySelect :value="null" type="text" :error="errors.soum_district_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Сум,Дүүрэг" :url="`/admin/soum_districts`" @changeId="id=>form.soum_district_id=id" />
          <MySelect :value="null" type="text" :error="errors.bag_horoo_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Баг,Хороо" :url="`/admin/bag_horoos`" @changeId="id=>form.bag_horoo_id=id" />
          <MyInput v-model="form.address" type="text" :error="errors.address" class="pr-6 pb-8 w-full lg:w-1/2" label="Хаяг" />
          <MySelect :value="null" type="text" :error="errors.user_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Бүртгэсэн Хүн" :url="`/admin/users`" @changeId="id=>form.user_id=id" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Registers</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Layouts/Admin.vue'
import LoadingButton from '@/Components/LoadingButton.vue'
import NumberInput from '@/Components/MyInput.vue'
import MyInput from '@/Components/MyInput.vue'
import MySelect from '@/Components/MySelect.vue'

export default {
  metaInfo: { title: 'Create Registers' },
  components: {
    LoadingButton,
    NumberInput,
    MyInput,
    MySelect,
  },
  layout: Layout,
  props: {
    errors: Object,
    data:Object,
    host: String,
  },
  data() {
    return {
      form: this.$inertia.form({
        id: null,
        long: null,
        lat: null,
        description: null,
        resolve_desc: null,
        reason_id: null,
        status_id: null,
        aimag_city_id: null,
        soum_district_id: null,
        bag_horoo_id: null,
        address: null,
        user_id: null,
        created_at: null,
        updated_at: null,
      }),
    }
  },
  methods: {
    submit() {
      this.form.post(this.route('admin.registers.store'))
    },
  },
}
</script>
