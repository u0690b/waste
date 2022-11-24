<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.soum_districts.index')">Soum Districts</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Edit
      {{ title }}
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <MyInput v-model="form.code" type="text" :error="errors.code" class="pr-6 pb-8 w-full lg:w-1/2" label="Код" />
          <MyInput v-model="form.name" type="text" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Аймаг Нэр" />
          <MySelect :value="data.aimag_city" type="text" :error="errors.aimag_city_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Аймаг/Нийслэл" :url="`/admin/aimag_cities`" @changeId="id=>form.aimag_city_id=id" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Soum Districts</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Edit Soum Districts</loading-button>
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
  metaInfo: { title: 'Edit Soum Districts' },
  components: {
    LoadingButton,
    NumberInput,
    MyInput,
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
        aimag_city_id: this.data.aimag_city_id,
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
      this.form.put(this.route('admin.soum_districts.update',this.data.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this soum_districts?')) {
        this.$inertia.delete(this.route('admin.soum_districts.destroy', this.data.id))
      }
    },
  },
}
</script>
