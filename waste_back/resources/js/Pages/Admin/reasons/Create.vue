<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <h2 class="text-2xl text-gray-600">Шалтгаан бүртгэл</h2>
    <div class="flex items-center space-x-1 text-xs">
      <router-link to="/" class="font-bold text-indigo-700">Нүүр хуудас</router-link>
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-2 w-2"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M9 5l7 7-7 7"
        />
      </svg>
      <span class="text-gray-600">Шалтгаан бүртгэл</span>
    </div>
  </div>
  <div class="p-4 mt-8 sm:px-8 sm:py-4">
    <div class="p-4 bg-white rounded">
      <div class="bg-white rounded shadow max-w-3x max-w-3xl">
        <form @submit.prevent="submit">
          <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
            <MyInput
              v-model="form.name"
              type="text"
              :error="errors.name"
              class="pr-6 pb-8 w-full lg:w-1/2"
              label="Шалтгаан"
            />
            <MySelect
              :value="null"
              type="text"
              :error="errors.place_id"
              class="pr-6 pb-8 w-full lg:w-1/2"
              label="Байгууллага"
              :url="`/admin/places`"
              @changeId="(id) => (form.place_id = id)"
            />
          </div>
          <div
            class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center"
          >
            <loading-button :loading="form.processing" class="btn-indigo" type="submit"
              >Хадгалах</loading-button
            >
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
  metaInfo: { title: "Create Reasons" },
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
        name: null,
        place_id: null,
        created_at: null,
        updated_at: null,
      }),
    };
  },
  methods: {
    submit() {
      this.form.post(this.route("admin.reasons.store"));
    },
  },
};
</script>
