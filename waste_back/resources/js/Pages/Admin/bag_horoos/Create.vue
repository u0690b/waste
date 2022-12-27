<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <h2 class="text-xl text-gray-600">
      <inertia-link class="text-gray-600 hover:text-gray-800 font-bold" :href="route('admin.bag_horoos.index')">
        Баг/хороо бүртгэл</inertia-link>
    </h2>
    <div class="flex items-center space-x-1 text-xs">
      <inertia-link href="/" class="font-bold text-indigo-700 text-sm">Нүүр хуудас</inertia-link>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <span class="text-gray-600 text-sm">Баг/хороо бүртгэл</span>
    </div>
  </div>
  <SharedState></SharedState>
  <div class="p-4 mt-8 sm:px-8 sm:py-4">
    <div class="p-4 bg-white flex flex-col items-center justify-center rounded">
      <div class="bg-white rounded shadow w-2/5">
        <form @submit.prevent="submit">
          <div class="p-8 -mr-6 -mb-8 flex-wrap">
            <MyInput v-model="form.code" type="text" :error="errors.code" label="Баг/хороо код" />
            <MyInput v-model="form.name" type="text" :error="errors.name" class="my-3" label="Баг/хороо нэр" />
            <MySelect :value="null" :error="errors.soum_district_id" class="my-3" label="Сум/дүүрэг нэр"
              :url="`/admin/soum_districts`" @changeId="(id) => (form.soum_district_id = id)" />
          </div>
          <div class="flex justify-center">
            <button :loading="form.processing"
              class="flex bg-gray-600 p-3 my-3 text-white rounded text-base hover:bg-gray-500" type="submit">
              Хадгалах
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Layout from "@/Layouts/Admin.vue";
import LoadingButton from "@/Components/LoadingButton.vue";
import NumberInput from "@/Components/MyInput.vue";
import MyInput from "@/Components/MyInput.vue";
import MySelect from "@/Components/MySelect.vue";

export default {
  metaInfo: { title: "Create Bag Horoos" },
  components: {
    LoadingButton,
    NumberInput,
    MyInput,
    MySelect,
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
        code: null,
        name: null,
        soum_district_id: null,
        created_at: null,
        updated_at: null,
      }),
    };
  },
  methods: {
    submit() {
      this.form.post(this.route("admin.bag_horoos.store"));
    },
  },
};
</script>
