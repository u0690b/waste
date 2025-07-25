<template>
  <div>

    <div class="bg-white rounded shadow overflow-hidden max-w-3xl p-6">
      <h1 class="mb-8 font-bold text-3xl">
        <ILink class="text-indigo-400 hover:text-indigo-600" :href="route('admin.attached_files.index')">Attached Files</ILink>
        <span class="text-indigo-400 font-medium">/</span> Create
      </h1>
      <form @submit.prevent="submit">
        <div class="grid grid-cols-2 gap-2 ">
          <MySelect :value="null" type="text" :error="errors.register_id" class="" label="Зөрчлийн Бүртгэл" :url="`/admin/registers`" @changeId="id => form.register_id = id" />
          <MyInput v-model="form.path" type="text" :error="errors.path" class="" label="Файлын Зам" />
          <MyInput v-model="form.type" type="text" :error="errors.type" class="" label="Төрөл" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Attached Files</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
  import Layout from '@/Layouts/Admin.vue'
  import LoadingButton from '@/Components/LoadingButton.vue'
  import NumberInput from '@/Components/MyInput.vue'
  import MySelect from '@/Components/MySelect.vue'
  import MyInput from '@/Components/MyInput.vue'

  export default {
    metaInfo: { title: 'Create Attached Files' },
    components: {
      LoadingButton,
      NumberInput,
      MySelect,
      MyInput,
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
          register_id: null,
          path: null,
          type: null,
          created_at: null,
          updated_at: null,
        }),
      }
    },
    methods: {
      submit() {
        this.form.post(this.route('admin.attached_files.store'))
      },
    },
  }
</script>
