<template>
  <div>
    <div class="bg-white rounded shadow max-w-3x max-w-3xl p-6">
      <h1 class="mb-8 font-bold text-3xl border-b">
        <inertia-link
          class="text-indigo-400 hover:text-indigo-600"
          :href="route('admin.users.index')"
          >Хэрэглэгч
        </inertia-link>
        <span class="text-indigo-400 font-medium">/</span> бүртгэх
      </h1>
      <form @submit.prevent="submit">
        <div class="grid grid-cols-2 gap-2">
          <MyInput v-model="form.name" :error="errors.name" label="Хэрэглэгчийн нэр" />
          <MyInput v-model="form.username" :error="errors.username" label="Нэвтрэх нэр" />
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
        <div
          class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center"
        >
          <loading-button :loading="form.processing" class="btn-indigo" type="submit"
            >Хадгалах
          </loading-button>
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
