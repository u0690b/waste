<template>
  <div>
   
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl p-6">
     <h1 class="mb-8 font-bold text-3xl">
        <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.resolves.index')">Resolves</inertia-link>
        <span class="text-indigo-400 font-medium">/</span> Edit
        {{ title }}
      </h1>
      <form @submit.prevent="submit">
        <div class="grid grid-cols-2 gap-2 ">
          <MyInput v-model="form.name" type="text" :error="errors.name" class="" label="Шийдвэрийн Төрөл" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Resolves</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Edit Resolves</loading-button>
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
  metaInfo: { title: 'Edit Resolves' },
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
      this.form.put(this.route('admin.resolves.update',this.data.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this resolves?')) {
        this.$inertia.delete(this.route('admin.resolves.destroy', this.data.id))
      }
    },
  },
}
</script>
