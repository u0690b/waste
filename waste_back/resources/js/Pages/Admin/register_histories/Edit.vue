<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.register_histories.index')">Register Histories</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Edit
      {{ title }}
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <my-select :value="data.register" type="text" :error="errors.register_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Register Id" :url="`${host}/commons?t=register_id`" @changeId="id=>form.register_id=id" />
          <number-input v-model="form.long" type="number" :error="errors.long" class="pr-6 pb-8 w-full lg:w-1/2" label="Long" />
          <number-input v-model="form.lat" type="number" :error="errors.lat" class="pr-6 pb-8 w-full lg:w-1/2" label="Lat" />
          <text-input v-model="form.description" type="text" :error="errors.description" class="pr-6 pb-8 w-full lg:w-1/2" label="Description" />
          <text-input v-model="form.resolve_desc" type="text" :error="errors.resolve_desc" class="pr-6 pb-8 w-full lg:w-1/2" label="Resolve Desc" />
          <my-select :value="data.reason" type="text" :error="errors.reason_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Reason Id" :url="`${host}/commons?t=reason_id`" @changeId="id=>form.reason_id=id" />
          <my-select :value="data.status" type="text" :error="errors.status_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Status Id" :url="`${host}/commons?t=status_id`" @changeId="id=>form.status_id=id" />
          <my-select :value="data.aimag_city" type="text" :error="errors.aimag_city_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Aimag City Id" :url="`${host}/commons?t=aimag_city_id`" @changeId="id=>form.aimag_city_id=id" />
          <my-select :value="data.soum_district" type="text" :error="errors.soum_district_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Soum District Id" :url="`${host}/commons?t=soum_district_id`" @changeId="id=>form.soum_district_id=id" />
          <my-select :value="data.bag_horoo" type="text" :error="errors.bag_horoo_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Bag Horoo Id" :url="`${host}/commons?t=bag_horoo_id`" @changeId="id=>form.bag_horoo_id=id" />
          <text-input v-model="form.address" type="text" :error="errors.address" class="pr-6 pb-8 w-full lg:w-1/2" label="Address" />
          <my-select :value="data.user" type="text" :error="errors.user_id" class="pr-6 pb-8 w-full lg:w-1/2" label="User Id" :url="`${host}/commons?t=user_id`" @changeId="id=>form.user_id=id" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Register Histories</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Edit Register Histories</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Layouts/Admin'
import LoadingButton from '@/Components/LoadingButton'
import NumberInput from '@/Components/MyInput'
import MySelect from '@/Components/MySelect'
import TextInput from '@/Components/MyInput'

export default {
  metaInfo: { title: 'Edit Register Histories' },
  components: {
    LoadingButton,
    NumberInput,
    MySelect,
    TextInput,
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
        register_id: this.data.register_id,
        long: this.data.long,
        lat: this.data.lat,
        description: this.data.description,
        resolve_desc: this.data.resolve_desc,
        reason_id: this.data.reason_id,
        status_id: this.data.status_id,
        aimag_city_id: this.data.aimag_city_id,
        soum_district_id: this.data.soum_district_id,
        bag_horoo_id: this.data.bag_horoo_id,
        address: this.data.address,
        user_id: this.data.user_id,
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
      this.form.put(this.route('admin.register_histories.update',this.data.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this register_histories?')) {
        this.$inertia.delete(this.route('admin.register_histories.destroy', this.data.id))
      }
    },
  },
}
</script>
