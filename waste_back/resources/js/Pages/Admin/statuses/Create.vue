<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link
        class="text-indigo-400 hover:text-indigo-600"
        :href="route('admin.statuses.index')"
        >Төлөв</inertia-link
      >
      <span class="text-indigo-400 font-medium">/</span> бүртгэх
    </h1>
    <div class="bg-white rounded shadow max-w-3x max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <MyInput
            v-model="form.name"
            type="text"
            :error="errors.name"
            class="pr-6 pb-8 w-full lg:w-1/2"
            label="Төлөв"
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
</template>

<script>
import Layout from "@/Layouts/Admin.vue";
import LoadingButton from "@/Components/LoadingButton.vue";
import NumberInput from "@/Components/MyInput.vue";
import MyInput from "@/Components/MyInput.vue";

export default {
  metaInfo: { title: "Create Statuses" },
  components: {
    LoadingButton,
    NumberInput,
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
        name: null,
        created_at: null,
        updated_at: null,
      }),
    };
  },
  methods: {
    submit() {
      this.form.post(this.route("admin.statuses.store"));
    },
  },
};
</script>
