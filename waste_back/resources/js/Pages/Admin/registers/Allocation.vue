<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <h2 class="text-2xl text-gray-600 underline font-bold">Зөрчлийн бүртгэл</h2>
    <div class="flex items-center space-x-1 text-xs">
      <inertia-link href="/" class="font-bold text-indigo-700 text-sm">Нүүр хуудас</inertia-link>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <span class="text-gray-600 text-sm">Зөрчлийн бүртгэл</span>
    </div>
  </div>
  <div class="px-4 py-2 bg-white border rounded-md shadow sm:mx-8">
    <form @submit.prevent="submit">
      <div class="flex">
        <MySelect :value="data.comf_user" :error="errors.comf_user_id" class="w-96" label="Бүртгэгч"
          :url="`/admin/users?soum_district_id=${data.soum_district_id}&roles=mhb`"
          @changeId="(id) => (form.comf_user_id = id)" />

        <LoadingButton :loading="form.processing"
          class="flex bg-gray-600  p-3 mx-4 mt-3 text-white rounded text-base hover:bg-gray-500" type="submit">
          Хуваарилах</LoadingButton>
      </div>
    </form>
  </div>
  <div class="grid grid-cols-1 px-4 gap-4 mt-8 sm:grid-cols-2 sm:px-8">
    <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow">
      <h3 class="text-xl text-gray-600 mb-4 tracking-wider">Үндсэн мэдээлэл</h3>
      <RegisterCard :item="data" hideMoreButton @select="select">
        <p class="mb-3 text-sm text-gray-700 dark:text-gray-400">
          <span class="font-bold text-black">#Бүртгэсэн хүн:</span>
        </p>
        <p class="mb-3 text-xs text-gray-700 dark:text-gray-400 italic"> {{ data.reg_user.name }}</p>
        <h5 v-if="data.resolve_desc" class="mb-3 text-sm text-gray-700 dark:text-gray-400"> <span
            class="font-bold text-black">#Шийдвэрлэсэн хүн:</span></h5>
        <p v-if="data.resolve_desc" class="mb-3 font-normal text-gray-700 dark:text-gray-400">
          - {{ data.resolve_desc }}
        </p>

      </RegisterCard>
    </div>
    <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow">
      <h3 class="text-xl text-gray-600 mb-4">Байрлал /Газрын зураг/</h3>
      <ShowMapPoint :key="'fucing' + data.id" :coordinate="[data.long, data.lat]"></ShowMapPoint>
    </div>
  </div>
  <div class="grid grid-cols-1 px-4 gap-4 mt-8 sm:grid-cols-2 sm:px-8">
    <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow">
      <h3 class="text-xl text-gray-600 mb-4 tracking-wider">Нотлох баримт /Зураг/</h3>
      <Carousel>
        <Slide v-for="slide in data.attached_images" :key="slide">
          <div class="carousel__item">
            <img :src="slide.path" alt="" @click="() => selected = slide.path">
          </div>
        </Slide>
        <template #addons>
          <Pagination />
        </template>
      </Carousel>
      <Modal :show="!!selected" @close="() => (selected = null)">
        <img :src="selected" alt="" />
      </Modal>
    </div>
    <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow">
      <h3 class="text-xl text-gray-600 mb-4 tracking-wider">Нотлох баримт /Бичлэг/</h3>
      <video v-if="data.attached_video?.path" class="w-full" controls>
        <source :src="data.attached_video.path">
        <a :href="data.attached_video.path"> Бичлэг татах</a>
      </video>

    </div>
  </div>

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
    MySelect
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
