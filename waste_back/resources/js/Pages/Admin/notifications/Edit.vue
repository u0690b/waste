<template>
  <div>
   
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl p-6">
     <h1 class="mb-8 font-bold text-3xl">
        <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.notifications.index')">Notifications</inertia-link>
        <span class="text-indigo-400 font-medium">/</span> Edit
        {{ title }}
      </h1>
      <form @submit.prevent="submit">
        <div class="grid grid-cols-2 gap-2 ">
          <MySelect :value="data.user" type="text" :error="errors.user_id" class="" label="Хэнээс" :url="`/admin/users`" @changeId="id=>form.user_id=id" />
          <MyInput v-model="form.type" type="text" :error="errors.type" class="" label="Төрөл" />
          <MyInput v-model="form.title" type="text" :error="errors.title" class="" label="Гарчиг" />
          <textarea-input v-model="form.content" type="text" :error="errors.content" class="" label="Агуулга" />
          <MyInput v-model="form.read_at" type="date" :error="errors.read_at" class="" label="Уншсан" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Notifications</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Edit Notifications</loading-button>
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
  metaInfo: { title: 'Edit Notifications' },
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
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        id: this.data.id,
        user_id: this.data.user_id,
        type: this.data.type,
        title: this.data.title,
        content: this.data.content,
        read_at: this.data.read_at,
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
      this.form.put(this.route('admin.notifications.update',this.data.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this notifications?')) {
        this.$inertia.delete(this.route('admin.notifications.destroy', this.data.id))
      }
    },
  },
}
</script>
