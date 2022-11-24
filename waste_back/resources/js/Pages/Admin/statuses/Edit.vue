<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.statuses.index')">Statuses</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Edit
      {{ title }}
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <MyInput v-model="form.name" type="text" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Төлөв" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Statuses</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Edit Statuses</loading-button>
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
  metaInfo: { title: 'Edit Statuses' },
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
        name: this.data.name,
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
      this.form.put(this.route('admin.statuses.update',this.data.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this statuses?')) {
        this.$inertia.delete(this.route('admin.statuses.destroy', this.data.id))
      }
    },
  },
}
</script>
