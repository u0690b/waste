<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.users.index')">Users Models
      </inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Edit
      {{ title }}
    </h1>
    <div class="bg-white rounded shadow  max-w-3x max-w-3xl">
      <form @submit.prevent="submit">
        <div class="grid grid-cols-2 gap-2 ">
          <MyInput v-model="form.name" :error="errors.name" label="Name" />
          <MyInput v-model="form.username" :error="errors.username" label="Username" />
          <MyInput v-model="form.password" type="password" autocomplete="new-password" :error="errors.password"
            label="Password" />
          <MySelect :value="data.aimag_city" :error="errors.aimag_city_id" label="Aimag City Id"
            :url="`/admin/aimag_cities`" @changeId="id => form.aimag_city_id = id" />
          <MySelect :value="data.soum_district" :error="errors.soum_district_id" label="Soum District Id"
            :url="`/admin/soum_districts`" @changeId="id => form.soum_district_id = id" />
          <MySelect :value="data.bag_horoo" :error="errors.bag_horoo_id" label="Bag Horoo Id" :url="`/admin/bag_horoos`"
            @changeId="id => form.bag_horoo_id = id" />
          <MySelect v-model="form.roles" :modelKey="true" :storedOptions="roles" :error="errors.roles" label="Roles"
            :filterable="true" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Users
            Models</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Edit Users Models
          </loading-button>
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
import TextareaInput from '@/Components/TextareaInput.vue'

export default {
  metaInfo: { title: 'Edit Users Models' },
  components: {
    LoadingButton,
    NumberInput,
    MyInput,
    MySelect,
    TextareaInput,
  },
  layout: Layout,
  props: {
    errors: Object,
    data: Object,
    host: String,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        id: this.data.id,
        name: this.data.name,
        username: this.data.username,
        password: this.data.password,
        aimag_city_id: this.data.aimag_city_id,
        soum_district_id: this.data.soum_district_id,
        bag_horoo_id: this.data.bag_horoo_id,
        roles: this.data.roles,
        remember_token: this.data.remember_token,
        created_at: this.data.created_at,
        updated_at: this.data.updated_at,
      }),
      roles: [
        { id: 'admin', name: 'admin' },
        { id: 'register', name: 'Бүртгэгч' },
      ]
    }

  },
  computed: {
    title() {
      return this.form.name ?? this.form.id
    },
  },
  methods: {
    submit() {
      this.form.put(this.route('admin.users.update', this.data.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this users_models?')) {
        this.$inertia.delete(this.route('admin.users.destroy', this.data.id))
      }
    },
  },
}
</script>
