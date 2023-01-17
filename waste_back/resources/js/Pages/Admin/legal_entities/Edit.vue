<template>
  <div>

    <div class="bg-white rounded shadow overflow-hidden max-w-3xl p-6">
      <h1 class="mb-8 font-bold text-3xl">
        <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.entities.index')">Legal
          Entities</inertia-link>
        <span class="text-indigo-400 font-medium">/</span> Edit
        {{ title }}
      </h1>
      <form @submit.prevent="submit">
        <div class="grid grid-cols-2 gap-2 ">
          <MyInput v-model="form.register" type="text" :error="errors.register" class=""
            label="Хуулийн Этгээдийн Регистр" />
          <MyInput v-model="form.name" type="text" :error="errors.name" class="" label="Хуулийн Этгээдийн Нэр" />
          <MySelect :value="data.industry" type="text" :error="errors.industry_id" class=""
            label="Үйл Ажиллагааны Чиглэл" :url="`/admin/industries`" @changeId="id => form.industry_id = id" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Legal
            Entities</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Edit Legal
            Entities</loading-button>
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
  metaInfo: { title: 'Edit Legal Entities' },
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
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        id: this.data.id,
        register: this.data.register,
        name: this.data.name,
        industry_id: this.data.industry_id,
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
      this.form.put(this.route('admin.entities.update', this.data.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this entities?')) {
        this.$inertia.delete(this.route('admin.entities.destroy', this.data.id))
      }
    },
  },
}
</script>
