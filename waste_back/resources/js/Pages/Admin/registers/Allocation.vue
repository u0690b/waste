<template>
  <Show :errors='errors' :data='data' :host='host'>
    <div class="px-4 py-2 bg-white border rounded-md shadow sm:mx-8">
      <form @submit.prevent="submit">
        <div class="flex">
          <MySelect :value="data.comf_user" :error="errors.comf_user_id" class="w-96" label="Бүртгэгч"
            :url="`/admin/users?soum_district_id=${data.soum_district_id}`"
            @changeId="(id) => (form.comf_user_id = id)" />

          <LoadingButton :loading="form.processing"
            class="flex bg-gray-600  p-3 mx-4 mt-3 text-white rounded text-base hover:bg-gray-500" type="submit">
            Хуваарилах</LoadingButton>
        </div>
      </form>
    </div>
  </Show>


</template>

<script>
import Layout from "@/Layouts/Admin.vue";
import LoadingButton from "@/Components/LoadingButton.vue";
import NumberInput from "@/Components/MyInput.vue";
import MyInput from "@/Components/MyInput.vue";
import RegisterCard from "@/Components/RegisterCard.vue";
import ShowMapPoint from "@/Components/ShowMapPoint.vue";
import { Carousel, Pagination, Slide } from "vue3-carousel";
import Modal from "@/Components/Modal.vue";
import { ref } from "vue";
import MySelect from "@/Components/MySelect.vue";
import Show from "./Show.vue";
export default {
  metaInfo: { title: "Edit Registers" },
  components: {
    LoadingButton,
    NumberInput,
    MyInput,
    RegisterCard,
    ShowMapPoint,
    Carousel,
    Slide,
    Pagination,
    Modal,
    MySelect,
    Show
  },
  layout: Layout,
  props: {
    errors: Object,
    data: Object,
    host: String,
  },
  setup(props) {


    const isOpen = ref(false);

    function setIsOpen(value) {
      isOpen.value = value;
    }
    return {
      isOpen,
      setIsOpen
    }
  },
  remember: "form",

  data() {
    return {
      selected: null,
      form: this.$inertia.form({
        id: this.data.id,
        comf_user_id: this.data.comf_user_id,
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
      this.form.put(this.route("admin.register.allocation_store", this.data.id));
    },
    destroy() {
      if (confirm("Та устгахдаа итгэлтэй байна уу?")) {
        this.$inertia.delete(this.route("admin.registers.destroy", this.data.id));
      }
    },
    select(v) {
      this.selected = v;
    },
  },
};
</script>
