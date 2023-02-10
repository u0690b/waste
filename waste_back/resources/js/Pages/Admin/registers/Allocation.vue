<template>
  <Show :errors='errors' :data='data' :host='host' :auth="auth">
    <div class="grid grid-cols-1 px-4 gap-4 mt-8 sm:grid-cols-1 sm:px-8">
      <div class="px-3 py-2 bg-white border rounded-md shadow">
        <h3 class="text-lg text-gray-600 mb-4">Шийдвэрлэлтийн мэдээлэл оруулах</h3>
        <form @submit.prevent="submit">
          <div class="grid grid-cols-4 gap-4">
            <div>
              <label class="text-sm font-medium text-gray-900 dark:text-white" for="address">Бүртгэгч</label>
              <MySelect :value="data.comf_user" :error="errors.comf_user_id"
                class="text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                :url="`/admin/users?soum_district_id=${data.soum_district_id}`"
                @changeId="(id) => (form.comf_user_id = id)" />
            </div>

            <div class="py-1">
              <button :loading="form.processing"
                class="mx-4 bg-gray-600 p-2 my-5 text-white rounded text-base hover:bg-gray-500" type="submit">
                Хадгалах
              </button>
              <button :loading="form.processing"
                class=" bg-gray-600 p-2 my-5 text-white rounded text-base hover:bg-gray-500">
                <inertia-link class="text-white hover:text-white" :href="route('admin.registers.index')">
                  Буцах</inertia-link>
              </button>
            </div>

          </div>
        </form>
      </div>
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
    auth: Object,
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
