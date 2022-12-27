<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <h2 class="text-xl text-gray-600">
      <inertia-link class="text-gray-600 hover:text-gray-800 font-bold" :href="route('admin.soum_districts.index')">
        Сум/дүүрэг засах</inertia-link>
    </h2>
    <div class="flex items-center space-x-1 text-xs">
      <inertia-link href="/" class="font-bold text-indigo-700 text-sm">Нүүр хуудас</inertia-link>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <span class="text-gray-600 text-sm">Сум/дүүрэг засах</span>
    </div>
  </div>
  <SharedState></SharedState>
  <div class="p-4 mt-8 sm:px-8 sm:py-4">
    <div class="p-4 bg-white flex flex-col items-center justify-center rounded">
      <div class="mb-6 flex justify-between items-center">
        <div class="relative text-gray-400"></div>
      </div>
      <div class="bg-white rounded shadow w-2/5">
        <form @submit.prevent="submit">
          <div class="p-8 -mr-6 -mb-8 flex-wrap">
            <MyInput v-model="form.code" type="text" :error="errors.code" label="Сум/дүүрэг код" />
            <MyInput v-model="form.name" type="text" :error="errors.name" class="my-3" label="Сум/дүүрэг нэр" />
            <MySelect :value="data.aimag_city" :error="errors.aimag_city_id" class="my-3" label="Аймаг/нийслэл нэр"
              :url="`/admin/aimag_cities`" @changeId="(id) => (form.aimag_city_id = id)" />
          </div>
          <div class="flex justify-center">
            <button :loading="form.processing"
              class="flex bg-gray-600 p-3 mx-3 text-white rounded text-base hover:bg-gray-500" type="submit">
              Засах
            </button>
            <button :loading="form.processing"
              class="flex bg-gray-600 p-3 mx-4 text-white rounded text-base hover:bg-gray-500" @click="goBack">
              Буцах
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
  metaInfo: { title: "Edit Soum Districts" },
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
  remember: "form",
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
    };
  },
  computed: {
    title() {
      return this.form.name ?? this.form.id;
    },
  },
  methods: {
    submit() {
      this.form.put(this.route("admin.soum_districts.update", this.data.id));
    },
    destroy() {
      if (confirm("Та устгахдаа итгэлтэй байна уу?")) {
        this.$inertia.delete(this.route("admin.soum_districts.destroy", this.data.id));
      }
    },
  },
};
</script>
