<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <h2 class="text-2xl text-gray-600">
      <inertia-link
        class="text-black hover:text-gray-800 underline font-bold"
        :href="route('admin.users.index')"
      >
        Хэрэглэгч бүртгэл</inertia-link
      >
    </h2>
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
      <span class="text-gray-600">Хэрэглэгч бүртгэл</span>
    </div>
  </div>
  <div class="p-4 mt-8 sm:px-8 sm:py-4">
    <div class="p-4 bg-white flex flex-col items-center justify-center rounded">
      <div class="bg-white rounded w-2/5">
        <form @submit.prevent="submit">
          <div class="p-8 -mr-6 -mb-8 flex-wrap">
            <MyInput v-model="form.name" :error="errors.name" label="Хэрэглэгчийн нэр" />
            <MyInput
              v-model="form.username"
              :error="errors.username"
              label="Нэвтрэх нэр"
            />
            <MyInput
              v-model="form.password"
              type="password"
              autocomplete="new-password"
              :error="errors.password"
              label="Нууц үг"
            />
            <MyInput
              v-model="form.password_confirmation"
              type="password"
              autocomplete="new-password"
              :error="errors.password_confirmation"
              label="Нууц үг баталгаажуулалт"
            />

            <MySelect
              :value="null"
              :error="errors.aimag_city_id"
              label="Аймаг/нийслэл"
              :url="`/admin/aimag_cities`"
              @changeId="(id) => (form.aimag_city_id = id)"
            />
            <MySelect
              :value="null"
              :error="errors.soum_district_id"
              label="Сум/дүүрэг"
              :url="`/admin/soum_districts`"
              @changeId="(id) => (form.soum_district_id = id)"
            />

            <MySelect
              :value="null"
              :error="errors.bag_horoo_id"
              label="Баг/хороо"
              :url="`/admin/bag_horoos`"
              @changeId="(id) => (form.bag_horoo_id = id)"
            />
            <MySelect
              v-model="form.roles"
              :modelKey="true"
              :storedOptions="roles"
              :error="errors.roles"
              label="Эрх"
              :filterable="true"
            />
          </div>
          <div class="flex justify-center">
            <button
              :loading="form.processing"
              class="flex bg-gray-600 p-3 text-white rounded text-base hover:bg-gray-500"
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
import TextareaInput from "@/Components/TextareaInput.vue";

export default {
  metaInfo: { title: "Create Users Models" },
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
  data() {
    return {
      form: this.$inertia.form({
        id: null,
        name: null,
        username: null,
        password: null,
        password_confirmation: null,
        aimag_city_id: null,
        soum_district_id: null,
        bag_horoo_id: null,
        roles: null,
        remember_token: null,
        created_at: null,
        updated_at: null,
      }),
      roles: [
        { id: "admin", name: "Админ" },
        { id: "register", name: "Бүртгэгч" },
        { id: "dt", name: "Дүүргийн төлөөлөгч" },
        { id: "onb", name: "Олон нийтийн байцаагч" },
        { id: "mh", name: "МХЕГ" },
      ],
    };
  },
  methods: {
    submit() {
      this.form.post(this.route("admin.users.store"));
    },
  },
};
</script>
