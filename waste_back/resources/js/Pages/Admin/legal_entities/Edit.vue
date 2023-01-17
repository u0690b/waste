<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <h2 class="text-xl text-gray-600">
      <inertia-link class="text-gray-600 hover:text-gray-800 font-bold" :href="route('admin.legal_entities.index')">
        Хуулийн этгээд</inertia-link>
    </h2>
    <div class="flex items-center space-x-1 text-xs">
      <inertia-link href="/" class="font-bold text-indigo-700 text-sm">Нүүр хуудас</inertia-link>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <span class="text-gray-600 text-sm">Хуулийн этгээд</span>
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
            <MyInput v-model="form.industry" type="text" :error="errors.industry" class=""
              label="Үйл Ажиллагааны Чиглэл" />
          </div>
          <div class="flex justify-center">
            <button :loading="form.processing"
              class="flex bg-gray-600 p-3 my-3 text-white rounded text-base hover:bg-gray-500" type="submit">
              Хадгалах
            </button>
            <button :loading="form.processing"
              class="flex bg-gray-600  p-3 mx-4 my-3 text-white rounded text-base hover:bg-gray-500">
              <inertia-link class="text-white hover:text-white" :href="route('admin.legal_entities.index')">
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

export default {
  metaInfo: { title: 'Edit Legal Entities' },
  components: {
    LoadingButton,
    NumberInput,
    MyInput,
  },
  layout: Layout,
  props: {
    errors: Object,
    data: Object,
    host: String,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        id: this.data.id,
        register: this.data.register,
        name: this.data.name,
        industry: this.data.industry,
      }),
    }
  },
  computed: {
    title() {
      return this.form.name ?? this.form.id
    },
  },
  methods: {
    submit() {
      this.form.put(this.route('admin.legal_entities.update', this.data.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this legal_entities?')) {
        this.$inertia.delete(this.route('admin.legal_entities.destroy', this.data.id))
      }
    },
  },
}
</script>
