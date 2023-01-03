<template>
  <div>
   
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl p-6">
     <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.notifications.index')">Notifications</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
      <form @submit.prevent="submit">
        <div class="grid grid-cols-2 gap-2 ">
          <MySelect :value="null" type="text" :error="errors.user_id" class="" label="Хэнээс" :url="`/admin/users`" @changeId="id=>form.user_id=id" />
          <MyInput v-model="form.type" type="text" :error="errors.type" class="" label="Төрөл" />
          <MyInput v-model="form.title" type="text" :error="errors.title" class="" label="Гарчиг" />
          <textarea-input v-model="form.content" type="text" :error="errors.content" class="" label="Агуулга" />
          <MyInput v-model="form.read_at" type="date" :error="errors.read_at" class="" label="Уншсан" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Notifications</loading-button>
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
import TextareaInput from '@/Components/TextareaInput.vue'

export default {
  metaInfo: { title: 'Create Notifications' },
  components: {
    LoadingButton,
    NumberInput,
    MySelect,
    MyInput,
    TextareaInput,
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
        user_id: null,
        type: null,
        title: null,
        content: null,
        read_at: null,
      }),
    }
  },
  methods: {
    submit() {
      this.form.post(this.route('admin.notifications.store'))
    },
  },
}
</script>
