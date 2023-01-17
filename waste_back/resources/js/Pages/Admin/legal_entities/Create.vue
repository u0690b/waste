<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <h2 class="text-xl text-gray-600">
      <inertia-link class="text-gray-600 hover:text-gray-800 font-bold" :href="route('admin.statuses.index')">
        Төлөв бүртгэл</inertia-link>
    </h2>
    <div class="flex items-center space-x-1 text-xs">
      <inertia-link href="/" class="font-bold text-indigo-700 text-sm">Нүүр хуудас</inertia-link>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <span class="text-gray-600 text-sm">Төлөв бүртгэл</span>
    </div>
  </div>
  <div class="p-4 mt-8 sm:px-8 sm:py-4">
    <div class="p-4 bg-white flex flex-col items-center justify-center rounded">
      <div class="bg-white rounded shadow w-2/5">
        <form @submit.prevent="submit">
          <div class="grid grid-cols-2 gap-2 ">
            <MyInput v-model="form.register" type="text" :error="errors.register" class=""
              label="Хуулийн Этгээдийн Регистр" />
            <MyInput v-model="form.name" type="text" :error="errors.name" class="" label="Хуулийн Этгээдийн Нэр" />
            <MySelect :value="null" type="text" :error="errors.industry_id" class="col-span-2"
              label="Үйл Ажиллагааны Чиглэл" :url="`/admin/industries`" @changeId="id => form.industry_id = id" />
          </div>
          <div class="flex justify-center">
            <button :loading="form.processing"
              class="flex bg-gray-600 p-3 my-3 text-white rounded text-base hover:bg-gray-500" type="submit">
              Хадгалах
            </button>
            <button :loading="form.processing"
              class="flex bg-gray-600  p-3 mx-4 my-3 text-white rounded text-base hover:bg-gray-500">
              <inertia-link class="text-white hover:text-white" :href="route('admin.entities.index')">
                Буцах</inertia-link>
            </button>
          </div>
        </form>
      </div>
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
  metaInfo: { title: 'Create Legal Entities' },
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
        register: null,
        name: null,
        industry_id: null,
      }),
    }
  },
  methods: {
    submit() {
      this.form.post(this.route('admin.entities.store'))
    },
  },
}
</script>
