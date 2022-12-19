<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <h2 class="text-2xl text-gray-600">
      <inertia-link
        class="text-black hover:text-gray-800 underline font-bold"
        :href="route('admin.users.index')"
      >
        Хэрэглэгчийн мэдээлэл засах</inertia-link
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
      <span class="text-gray-600">Хэрэглэгчийн мэдээлэл засах</span>
    </div>
  </div>
  <div class="p-4 mt-8 sm:px-8 sm:py-4">
    <div class="p-4 bg-white flex flex-col items-center justify-center rounded">
      <div class="mb-6 flex justify-between items-center">
        <div class="relative text-gray-400"></div>
      </div>
      <div class="bg-white rounded shadow w-2/5">
        <form @submit.prevent="submit">
          <div class="p-8 -mr-6 -mb-8 flex-wrap">
            <MyInput
              v-model="form.username"
              disabled
              :error="errors.username"
              label="Нэвтрэх нэр"
            />
            <MyInput v-model="form.name" :error="errors.name" label="Хэрэглэгчийн нэр" />
            <MyInput v-model="form.phone" :error="errors.phone" label="Утас" />
            <MyInput
              v-model="form.password"
              type="password"
              autocomplete="new-password"
              :error="errors.password"
              label="Нууц үг"
            />

            <MySelect
              :value="data.aimag_city"
              :error="errors.aimag_city_id"
              label="Аймаг/нийслэл"
              :url="`/admin/aimag_cities`"
              @changeId="
                (id) => {
                  form.aimag_city_id = id;
                  form.soum_district_id = null;
                  form.bag_horoo_id = null;
                }
              "
            />

            <MySelect
              v-if="form.aimag_city_id"
              :value="data.soum_district"
              :error="errors.soum_district_id"
              label="Сум/дүүрэг"
              :url="`/admin/soum_districts?aimag_city_id=${form.aimag_city_id}`"
              @changeId="
                (id) => ((form.soum_district_id = id), (form.bag_horoo_id = null))
              "
            />

            <MySelect
              v-if="form.soum_district_id"
              :value="data.bag_horoo"
              :error="errors.bag_horoo_id"
              label="Баг/хороо"
              :url="`/admin/bag_horoos?soum_district_id=${form.soum_district_id}`"
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
              Засах
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
  metaInfo: { title: "Edit Users Models" },
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
  remember: "form",
  data() {
    return {
      form: this.$inertia.form({
        id: this.data.id,
        name: this.data.name,
        phone: this.data.phone,
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
        { id: "admin", name: "Админ" },
        { id: "register", name: "Бүртгэгч" },
        { id: "dt", name: "Дүүргийн төлөөлөгч" },
        { id: "onb", name: "Олон нийтийн байцаагч" },
        { id: "mh", name: "МХЕГ" },
      ],
    };
  },
  computed: {
    title() {
      return this.form.name ?? this.form.id;
    },
  },
  methods: {
    submit() {
      this.form.put(this.route("admin.users.update", this.data.id));
    },
    destroy() {
      if (confirm("Та устгахдаа итгэлтэй байна уу?")) {
        this.$inertia.delete(this.route("admin.users.destroy", this.data.id));
      }
    },
  },
};
</script>
