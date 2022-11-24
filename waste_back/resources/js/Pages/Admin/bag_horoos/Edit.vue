<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.bag_horoos.index')">Bag Horoos</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Edit
      {{ title }}
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.code" type="text" :error="errors.code" class="pr-6 pb-8 w-full lg:w-1/2" label="Code" />
          <text-input v-model="form.name" type="text" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
          <my-select :value="data.soum_district" type="text" :error="errors.soum_district_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Soum District Id" :url="`${host}/commons?t=soum_district_id`" @changeId="id=>form.soum_district_id=id" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Bag Horoos</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Edit Bag Horoos</loading-button>
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
  metaInfo: { title: 'Edit Bag Horoos' },
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
        code: this.data.code,
        name: this.data.name,
        soum_district_id: this.data.soum_district_id,
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
      this.form.put(this.route('admin.bag_horoos.update',this.data.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this bag_horoos?')) {
        this.$inertia.delete(this.route('admin.bag_horoos.destroy', this.data.id))
      }
    },
  },
}
</script>
