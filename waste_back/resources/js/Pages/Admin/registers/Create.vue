<template>
  <div>

    <div class="max-w-3xl p-6 overflow-hidden bg-white rounded shadow">
      <h1 class="mb-8 text-3xl font-bold">
        <ILink class="text-indigo-400 hover:text-indigo-600" :href="route('admin.registers.index')">Registers</ILink>
        <span class="font-medium text-indigo-400">/</span> Create
      </h1>
      <form @submit.prevent="submit">
        <div class="grid grid-cols-2 gap-2 ">
          <MyInput v-model="form.name" type="text" :error="errors.name" class="" label="Байгууллага, Аж Ахуйн Нэгжийн Нэр, Иргэний Овог Нэр" />
          <MyInput v-model="form.register" type="text" :error="errors.register" class="" label="Регистрийн Дугаар" />
          <MyInput v-model="form.chiglel" type="text" :error="errors.chiglel" class="" label="Үйл Ажиллагааны Чиглэл" />
          <MySelect type="text" :error="errors.aimag_city_id" class="" label="Аймаг,Нийслэл" :url="`/admin/aimag_cities`" @changeId="(id) => (form.aimag_city_id = id, form.bag_horoo_id = form.soum_district_id = null)" />
          <MySelect type="text" :error="errors.soum_district_id" class="" label="Сум,Дүүрэг" :url="`/admin/soum_districts?aimag_city_id=` + form.aimag_city_id" :disabled="!form.aimag_city_id" @changeId="(id) => { form.soum_district_id = id, form.bag_horoo_id = null }" />
          <MySelect type="text" :error="errors.bag_horoo_id" class="" label="Баг,Хороо" :url="`/admin/bag_horoos?aimag_city_id=` + form.aimag_city_id + `&soum_district_id=` + form.soum_district_id" :disabled="!form.soum_district_id" @changeId="(id) => (form.bag_horoo_id = id)" />

          <MyInput v-model="form.address" type="text" :error="errors.address" class="" label="Хаяг, Байршилд" />
          <MyInput v-model="form.description" type="text" :error="errors.description" class="" label="Гаргасан зөрчлийн Байдал" />
          <MySelect :value="null" type="text" :error="errors.reason_id" class="" label="зөрчлийн Төрөл" :url="`/admin/reasons`" @changeId="id => form.reason_id = id" />
          <MyInput v-model="form.zuil_zaalt" type="text" :error="errors.zuil_zaalt" class="" label="Зөрчсөн Хууль Тогтоомжийн Зүйл, Заалт" />
          <MyInput v-model="form.resolve_desc" type="text" :error="errors.resolve_desc" class="" label="Зөрчлийг Шийдвэрлэсэн Байдал" />
          <number-input v-model="form.long" type="number" :error="errors.long" class="" label="Уртраг" />
          <number-input v-model="form.lat" type="number" :error="errors.lat" class="" label="Өргөрөг" />
          <MySelect :value="null" type="text" :error="errors.reg_user_id" class="" label="Бүртгэсэн Хүн" :url="`/admin/users`" @changeId="id => form.reg_user_id = id" />
          <MySelect :value="null" type="text" :error="errors.comf_user_id" class="" label="Шийдвэрлэсэн Хүн" :url="`/admin/comf_users`" @changeId="id => form.comf_user_id = id" />
          <MySelect :value="null" type="text" :error="errors.status_id" class="" label="Төлөв" :url="`/admin/statuses`" @changeId="id => form.status_id = id" />
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-100 border-t border-gray-200">
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
      data: Object,
      host: String,
    },
    data() {
      return {
        form: this.$inertia.form({
          id: null,
          name: null,
          register: null,
          chiglel: null,
          aimag_city_id: null,
          soum_district_id: null,
          bag_horoo_id: null,
          address: null,
          description: null,
          reason_id: null,
          zuil_zaalt: null,
          resolve_desc: null,
          long: null,
          lat: null,
          reg_user_id: null,
          comf_user_id: null,
          status_id: null,
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
