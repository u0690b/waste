<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <h2 class="text-2xl text-gray-600">
      <inertia-link
        class="text-black hover:text-gray-800 underline font-bold"
        :href="route('admin.aimag_cities.index')"
      >
        Аймаг/нийслэл бүртгэл</inertia-link
      >
    </h2>
    <div class="flex items-center space-x-1 text-xs">
      <inertia-link href="/" class="font-bold text-indigo-700">Нүүр хуудас</inertia-link>
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
      <span class="text-gray-600">Аймаг/нийслэл бүртгэл</span>
    </div>
  </div>
  <SharedState></SharedState>
  <div class="p-4 mt-8 sm:px-8 sm:py-4">
    <div class="p-4 bg-white flex flex-col items-center justify-center rounded">
      <div class="w-2/5">
        <form @submit.prevent="submit">
          <div class="p-8 -mr-6 -mb-8 flex-wrap">
            <MyInput
              v-model="form.code"
              type="text"
              :error="errors.code"
              label="Аймаг/нийслэл код"
            />
            <MyInput
              v-model="form.name"
              type="text"
              :error="errors.name"
              class="my-4"
              label="Аймаг/нийслэл нэр"
            />
          </div>
          <div class="flex justify-center">
            <button
              :loading="form.processing"
              class="flex bg-gray-600 p-3 my-3 text-white rounded text-base hover:bg-gray-500"
              type="submit"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-5 h-5"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125"
                />
              </svg>
              Хадгалах
            </button>

            <!-- <button
              :loading="form.processing"
              class="flex bg-blue-400 p-3 mx-4 text-white rounded text-base hover:bg-blue-500"
              @click="goBack"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-5 h-5"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M15 15l6-6m0 0l-6-6m6 6H9a6 6 0 000 12h3"
                />
              </svg>
              Буцах
            </button> -->
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
import SharedState from "@/Components/SharedState.vue";

export default {
  metaInfo: { title: "Create Aimag Cities" },
  components: {
    LoadingButton,
    NumberInput,
    MyInput,
    SharedState,
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
        created_at: null,
        updated_at: null,
      }),
    };
  },
  methods: {
    submit() {
      this.form.post(this.route("admin.aimag_cities.store"));
    },
    hasHistory() {
      return window.history.length > 2;
    },
  },
};
</script>
