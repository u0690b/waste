<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <h2 class="text-xl text-gray-600">
      <inertia-link class="text-gray-600 hover:text-gray-800  font-bold flex" :href="route('admin.users.index')">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
          class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
        </svg> Хэрэглэгч бүртгэл</inertia-link>
    </h2>
    <div class="flex items-center space-x-1 text-xs">
      <inertia-link href="/" class="font-bold text-indigo-700 text-sm">Нүүр хуудас</inertia-link>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <span class="text-gray-600 text-sm">Хэрэглэгч бүртгэл</span>
    </div>
  </div>
  <div class="p-4 mt-8 sm:px-8 sm:py-4">
    <div class="p-4 bg-white flex flex-col items-center justify-center rounded">
      <div class="bg-white rounded shadow w-2/5">
        <form @submit.prevent="submit">
          <div class="p-8 -mr-6 -mb-8 flex-wrap">
            <MyInput v-model="form.username" :error="errors.username" label="Нэвтрэх нэр" />
            <MyInput v-model="form.name" :error="errors.name" label="Хэрэглэгчийн нэр" />
            <MyInput v-model="form.phone" :error="errors.phone" label="Утас" />
            <MyInput v-model="form.password" type="password" autocomplete="new-password" :error="errors.password"
              label="Нууц үг" />
            <MyInput v-model="form.password_confirmation" type="password" autocomplete="new-password"
              :error="errors.password_confirmation" label="Нууц үг баталгаажуулалт" />

            <MySelect :value="aimag_city" :error="errors.aimag_city_id"
              :disabled="auth.user.roles == 'da' || auth.user.roles == 'mha'" label="Аймаг/нийслэл"
              :url="`/admin/aimag_cities`" @changeId="
                (id) => {
                  form.aimag_city_id = id;
                  form.soum_district_id = null;
                  form.bag_horoo_id = null;
                }
              " />

            <MySelect v-if="form.aimag_city_id" :value="soum_district"
              :disabled="auth.user.roles == 'da' || auth.user.roles == 'mha'" :error="errors.soum_district_id"
              label="Сум/дүүрэг" :url="`/admin/soum_districts?aimag_city_id=${form.aimag_city_id}`" @changeId="
                (id) => ((form.soum_district_id = id), (form.bag_horoo_id = null))
              " />

            <MySelect v-if="form.soum_district_id" :value="null" :error="errors.bag_horoo_id" label="Баг/хороо"
              :url="`/admin/bag_horoos?soum_district_id=${form.soum_district_id}`"
              @changeId="(id) => (form.bag_horoo_id = id)" />
            <MySelect v-model="form.roles" :modelKey="true" :storedOptions="roles" :error="errors.roles" label="Эрх"
              :filterable="true" />
          </div>
          <div class="flex justify-center">
            <button :loading="form.processing"
              class="flex bg-gray-600 p-3 my-3 text-white rounded text-base hover:bg-gray-500" type="submit">
              Хадгалах
            </button>
            <button :loading="form.processing"
              class="flex bg-gray-600  p-3 mx-4 my-3 text-white rounded text-base hover:bg-gray-500">
              <inertia-link class="text-white hover:text-white" :href="route('admin.users.index')">
                Буцах</inertia-link>
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
    aimag_city: Object,
    soum_district: Object,
    host: String,
    auth: Object,
  },
  data() {
    return {
      form: this.$inertia.form({
        id: null,
        phone: null,
        name: null,
        username: null,
        password: null,
        password_confirmation: null,
        aimag_city_id: this.aimag_city.id,
        soum_district_id: this.aimag_city.id,
        bag_horoo_id: null,
        roles: null,
        remember_token: null,
        created_at: null,
        updated_at: null,
      }),
      roles: this.auth.user.roles == 'admin' || this.auth.user.roles == 'zaa' ?
        [
          { id: "admin", name: "Админ" },
          { id: "zaa", name: "Захирагчийн ажлын алба" },
          { id: "mha", name: "МХ админ" },
          { id: "mhb", name: "МХ байцаагч" },
          { id: "da", name: "Дүүргийн админ" },
          { id: "hd", name: "Хороон дарга" },
          { id: "onb", name: "Олон нийтийн байцаагч" },
        ] :
        this.auth.user.roles == 'mha' ? [
          { id: "mha", name: "МХ админ" },
          { id: "mhb", name: "МХ байцаагч" },
        ] :
          this.auth.user.roles == 'da' ? [
            { id: "da", name: "Дүүргийн админ" },
            { id: "hd", name: "Хороон дарга" },
            { id: "onb", name: "Олон нийтийн байцаагч" },
          ] : []
      ,
    };
  },

  methods: {
    submit() {
      this.form.post(this.route("admin.users.store"));
    },
  },
};
</script>
