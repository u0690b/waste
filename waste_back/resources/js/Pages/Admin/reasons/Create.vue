<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.reasons.index')">Reasons</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" type="text" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
          <my-select :value="null" type="text" :error="errors.place_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Place Id" :url="`${host}/commons?t=place_id`" @changeId="id=>form.place_id=id" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Reasons</loading-button>
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
  metaInfo: { title: 'Create Reasons' },
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
  data() {
    return {
      form: this.$inertia.form({
        id: null,
        name: null,
        place_id: null,
        created_at: null,
        updated_at: null,
      }),
    }
  },
  methods: {
    submit() {
      this.form.post(this.route('admin.reasons.store'))
    },
  },
}
</script>
