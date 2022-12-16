<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.reasons.index')">Шалтгаан
      </inertia-link>
      <span class="text-indigo-400 font-medium">/</span> засах
      {{ title }}
    </h1>
    <div class="bg-white rounded shadow max-w-3x max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <MyInput v-model="form.name" type="text" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2"
            label="Шалтгаан" />
          <MySelect :value="data.place" type="text" :error="errors.place_id" class="pr-6 pb-8 w-full lg:w-1/2"
            label="Байгууллага" :url="`/admin/places`" @changeId="(id) => (form.place_id = id)" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">
            Устгах
          </button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Засах</loading-button>
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
  metaInfo: { title: "Edit Reasons" },
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
        place_id: this.data.place_id,
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
      this.form.put(this.route("admin.reasons.update", this.data.id));
    },
    destroy() {
      if (confirm("Та устгахдаа итгэлтэй байна уу?")) {
        this.$inertia.delete(this.route("admin.reasons.destroy", this.data.id));
      }
    },
  },
};
</script>
