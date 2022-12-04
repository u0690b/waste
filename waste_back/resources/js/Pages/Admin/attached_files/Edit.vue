<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.attached_files.index')">Attached Files</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Edit
      {{ title }}
    </h1>
    <div class="bg-white rounded shadow  max-w-3x max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <MyInput v-model="form.path" type="text" :error="errors.path" class="pr-6 pb-8 w-full lg:w-1/2" label="Файлын Зам" />
          <MyInput v-model="form.type" type="text" :error="errors.type" class="pr-6 pb-8 w-full lg:w-1/2" label="Төрөл" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Attached Files</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Edit Attached Files</loading-button>
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
  metaInfo: { title: 'Edit Attached Files' },
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
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        id: this.data.id,
        path: this.data.path,
        type: this.data.type,
        created_at: this.data.created_at,
        updated_at: this.data.updated_at,
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
      this.form.put(this.route('admin.attached_files.update',this.data.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this attached_files?')) {
        this.$inertia.delete(this.route('admin.attached_files.destroy', this.data.id))
      }
    },
  },
}
</script>
