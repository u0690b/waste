<template>
  <div>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl p-6">
      <h1 class="mb-8 font-bold text-3xl">
        <inertia-link
          class="text-indigo-400 hover:text-indigo-600"
          :href="route('admin.registers.index')"
          >Registers</inertia-link
        >
        <span class="text-indigo-400 font-medium">/</span> Edit
        {{ title }}
      </h1>
      <form @submit.prevent="submit">
        <div class="grid grid-cols-2 gap-2">
          <MyInput
            v-model="form.name"
            type="text"
            :error="errors.name"
            class=""
            label="Байгууллага, Аж Ахуйн Нэгжийн Нэр, Иргэний Овог Нэр"
          />
          <MyInput
            v-model="form.register"
            type="text"
            :error="errors.register"
            class=""
            label="Регистрийн Дугаар"
          />
          <MyInput
            v-model="form.chiglel"
            type="text"
            :error="errors.chiglel"
            class=""
            label="Үйл Ажиллагааны Чиглэл"
          />
          <MySelect
            :value="data.aimag_city"
            type="text"
            :error="errors.aimag_city_id"
            class=""
            label="Аймаг,Нийслэл"
            :url="`/admin/aimag_cities`"
            @changeId="(id) => (form.aimag_city_id = id)"
          />
          <MySelect
            :value="data.soum_district"
            type="text"
            :error="errors.soum_district_id"
            class=""
            label="Сум,Дүүрэг"
            :url="`/admin/soum_districts`"
            @changeId="(id) => (form.soum_district_id = id)"
          />
          <MySelect
            :value="data.bag_horoo"
            type="text"
            :error="errors.bag_horoo_id"
            class=""
            label="Баг,Хороо"
            :url="`/admin/bag_horoos`"
            @changeId="(id) => (form.bag_horoo_id = id)"
          />
          <MyInput
            v-model="form.address"
            type="text"
            :error="errors.address"
            class=""
            label="Хаяг, Байршилд"
          />
          <MyInput
            v-model="form.description"
            type="text"
            :error="errors.description"
            class=""
            label="Гаргасан Зөрчилийн Байдал"
          />
          <MySelect
            :value="data.reason"
            type="text"
            :error="errors.reason_id"
            class=""
            label="Зөрчилийн Төрөл"
            :url="`/admin/reasons`"
            @changeId="(id) => (form.reason_id = id)"
          />
          <MyInput
            v-model="form.zuil_zaalt"
            type="text"
            :error="errors.zuil_zaalt"
            class=""
            label="Зөрчсөн Хууль Тогтоомжийн Зүйл, Заалт"
          />
          <MyInput
            v-model="form.resolve_desc"
            type="text"
            :error="errors.resolve_desc"
            class=""
            label="Зөрчлийг Шийдвэрлэсэн Байдал"
          />
          <number-input
            v-model="form.long"
            type="number"
            :error="errors.long"
            class=""
            label="Уртраг"
          />
          <number-input
            v-model="form.lat"
            type="number"
            :error="errors.lat"
            class=""
            label="Өргөрөг"
          />
          <MySelect
            :value="data.reg_user"
            type="text"
            :error="errors.reg_user_id"
            class=""
            label="Бүртгэсэн Хүн"
            :url="`/admin/reg_users`"
            @changeId="(id) => (form.reg_user_id = id)"
          />
          <MySelect
            :value="data.comf_user"
            type="text"
            :error="errors.comf_user_id"
            class=""
            label="Шийдвэрлэсэн Хүн"
            :url="`/admin/comf_users`"
            @changeId="(id) => (form.comf_user_id = id)"
          />
          <MySelect
            :value="data.status"
            type="text"
            :error="errors.status_id"
            class=""
            label="Төлөв"
            :url="`/admin/statuses`"
            @changeId="(id) => (form.status_id = id)"
          />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button
            class="text-red-600 hover:underline"
            tabindex="-1"
            type="button"
            @click="destroy"
          >
            Delete Registers
          </button>
          <loading-button
            :loading="form.processing"
            class="btn-indigo ml-auto"
            type="submit"
            >Edit Registers</loading-button
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
import MySelect from "@/Components/MySelect.vue";

export default {
  metaInfo: { title: "Edit Registers" },
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
        name: this.data.name,
        register: this.data.register,
        chiglel: this.data.chiglel,
        aimag_city_id: this.data.aimag_city_id,
        soum_district_id: this.data.soum_district_id,
        bag_horoo_id: this.data.bag_horoo_id,
        address: this.data.address,
        description: this.data.description,
        reason_id: this.data.reason_id,
        zuil_zaalt: this.data.zuil_zaalt,
        resolve_desc: this.data.resolve_desc,
        long: this.data.long,
        lat: this.data.lat,
        reg_user_id: this.data.reg_user_id,
        comf_user_id: this.data.comf_user_id,
        status_id: this.data.status_id,
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
      this.form.put(this.route("admin.registers.update", this.data.id));
    },
    destroy() {
      if (confirm("Та устгахдаа итгэлтэй байна уу?")) {
        this.$inertia.delete(this.route("admin.registers.destroy", this.data.id));
      }
    },
  },
};
</script>
