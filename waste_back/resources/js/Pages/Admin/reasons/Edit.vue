<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.reasons.index')">Reasons</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Edit
      {{ title }}
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" type="text" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
          <my-select :value="data.place" type="text" :error="errors.place_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Place Id" :url="`${host}/commons?t=place_id`" @changeId="id=>form.place_id=id" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Reasons</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Edit Reasons</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Layouts/Admin'
import LoadingButton from '@/Components/LoadingButton'
import NumberInput from '@/Components/MyInput'
import TextInput from '@/Components/MyInput'
import MySelect from '@/Components/MySelect'

export default {
  metaInfo: { title: 'Edit Reasons' },
  components: {
    LoadingButton,
    NumberInput,
    TextInput,
    MySelect,
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
        place_id: this.data.place_id,
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
      this.form.put(this.route('admin.reasons.update',this.data.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this reasons?')) {
        this.$inertia.delete(this.route('admin.reasons.destroy', this.data.id))
      }
    },
  },
}
</script>
