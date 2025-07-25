<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <h2 class="text-xl text-gray-600">
      <ILink class="flex font-bold text-gray-600 hover:text-gray-800" :href="route('admin.users.index')">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
        </svg>Хэрэглэгчийн мэдээлэл засах
      </ILink>
    </h2>
    <div class="flex items-center space-x-1 text-xs">
      <ILink href="/" class="text-sm font-bold text-indigo-700">Нүүр хуудас</ILink>
      <svg xmlns="http://www.w3.org/2000/svg" class="w-2 h-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <span class="text-sm text-gray-600">Хэрэглэгчийн мэдээлэл засах</span>
    </div>
  </div>
  <div class="p-4 mt-8 sm:px-8 sm:py-4">
    <div class="flex flex-col items-center justify-center p-4 bg-white rounded">
      <div class="flex items-center justify-between mb-6">
        <div class="relative text-gray-400"></div>
      </div>
      <div class="w-2/5 bg-white rounded shadow pb-60">
        <form @submit.prevent="submit">
          <div class="flex-wrap p-8 -mb-8 -mr-6">
            <MyInput v-model="form.username" disabled :error="errors.username" label="Нэвтрэх нэр" />
            <MyInput v-model="form.name" :error="errors.name" label="Хэрэглэгчийн нэр" />
            <MyInput v-model="form.phone" :error="errors.phone" label="Утас" />
            <MyInput v-model="form.password" type="password" autocomplete="new-password" :error="errors.password" label="Нууц үг" />

            <MySelect :value="data.aimag_city" :error="errors.aimag_city_id" label="Аймаг/нийслэл" :url="`/admin/aimag_cities`" @changeId="
              (id) => {
                form.aimag_city_id = id;
                form.soum_district_id = null;
                form.bag_horoo_id = null;
              }
            " />

            <MySelect v-if="form.aimag_city_id" :value="data.soum_district" :error="errors.soum_district_id" label="Сум/дүүрэг" :url="`/admin/soum_districts?aimag_city_id=${form.aimag_city_id}`" @changeId="
              (id) => ((form.soum_district_id = id), (form.bag_horoo_id = null))
            " />

            <MySelect v-if="form.soum_district_id" :value="data.bag_horoo" :error="errors.bag_horoo_id" label="Баг/хороо" :url="`/admin/bag_horoos?soum_district_id=${form.soum_district_id}`" @changeId="(id) => (form.bag_horoo_id = id)" />
            <CustomSelect v-model="form.position" selectClass="!py-3" required clearable valueKey="name" :options="positions" label="Албан тушаал" />
            <MySelect v-model="form.roles" :modelKey="true" :storedOptions="roles" :error="errors.roles" label="Эрх" :filterable="true" />
          </div>
          <div class="flex justify-center">
            <button :loading="form.processing" class="flex p-3 my-3 text-base text-white bg-gray-600 rounded hover:bg-gray-500" type="submit">
              Засах
            </button>
            <button :loading="form.processing" class="flex p-3 mx-4 my-3 text-base text-white bg-gray-600 rounded hover:bg-gray-500">
              <ILink class="text-white hover:text-white" :href="route('admin.users.index')">
                Буцах</ILink>
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
  import positions from "./positions.json";
  import CustomSelect from "@/Components/CustomSelect.vue";
  export default {
    metaInfo: { title: "Edit Users Models" },
    components: {
      LoadingButton,
      NumberInput,
      MyInput,
      MySelect,
      TextareaInput,
      CustomSelect
    },
    layout: Layout,
    props: {
      errors: Object,
      data: Object,
      host: String,
      auth: Object,
    },
    remember: "form",
    data() {
      return {
        positions: positions,
        form: this.$inertia.form({
          id: this.data.id,
          name: this.data.name,
          phone: this.data.phone,
          username: this.data.username,
          password: this.data.password,
          position: this.data.position,
          aimag_city_id: this.data.aimag_city_id,
          soum_district_id: this.data.soum_district_id,
          bag_horoo_id: this.data.bag_horoo_id,
          roles: this.data.roles,
          remember_token: this.data.remember_token,
          created_at: this.data.created_at,
          updated_at: this.data.updated_at,
        }),
        roles: this.auth.user.roles == 'admin'  ?
          [
            { id: "admin", name: "Админ" },
            { id: "da", name: "Дүүрэг аймаг админ" },
            { id: "mha", name: "БОХУБ" },
          ] :
          this.auth.user.roles == 'da' ? [
            { id: "mha", name: "МХ байцаагч" },
          ] : []
        ,
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
