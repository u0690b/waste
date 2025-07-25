<template>
  <div>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl p-6">
      <h1 class="mb-8 font-bold text-3xl">
        <ILink class="text-indigo-400 hover:text-indigo-600" :href="route('admin.attached_files.index')">Attached Files</ILink>
        <span class="text-indigo-400 font-medium">/</span> Edit
        {{ title }}
      </h1>
      <form @submit.prevent="submit">
        <div class="grid grid-cols-2 gap-2">
          <MySelect :value="data.register" type="text" :error="errors.register_id" class="" label="Зөрчлийн Бүртгэл" :url="`/admin/registers`" @changeId="(id) => (form.register_id = id)" />
          <MyInput v-model="form.path" type="text" :error="errors.path" class="" label="Файлын Зам" />
          <MyInput v-model="form.type" type="text" :error="errors.type" class="" label="Төрөл" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">
            Delete Attached Files
          </button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Edit Attached Files</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
  import Layout from "@/Layouts/Admin.vue";
  import LoadingButton from "@/Components/LoadingButton.vue";
  import NumberInput from "@/Components/MyInput.vue";
  import MySelect from "@/Components/MySelect.vue";
  import MyInput from "@/Components/MyInput.vue";

  export default {
    metaInfo: { title: "Edit Attached Files" },
    components: {
      LoadingButton,
      NumberInput,
      MySelect,
      MyInput,
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
          register_id: this.data.register_id,
          path: this.data.path,
          type: this.data.type,
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
        this.form.put(this.route("admin.attached_files.update", this.data.id));
      },
      destroy() {
        if (confirm("Та устгахдаа итгэлтэй байна уу?")) {
          this.$inertia.delete(this.route("admin.attached_files.destroy", this.data.id));
        }
      },
    },
  };
</script>
