<template>
  <div>
   
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl p-6">
     <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.resolves.index')">Resolves</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
      <form @submit.prevent="submit">
        <div class="grid grid-cols-2 gap-2 ">
          <MyInput v-model="form.name" type="text" :error="errors.name" class="" label="Шийдвэрийн Төрөл" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Resolves</loading-button>
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

export default {
  metaInfo: { title: 'Create Resolves' },
  components: {
    LoadingButton,
    NumberInput,
    MyInput,
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
        name: null,
        created_at: null,
        updated_at: null,
      }),
    }
  },
  methods: {
    submit() {
      this.form.post(this.route('admin.resolves.store'))
    },
  },
}
</script>
