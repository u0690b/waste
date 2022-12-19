<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <h2 class="text-2xl text-gray-600 underline font-bold">Зөрчлийн бүртгэл</h2>
    <div class="flex items-center space-x-1 text-xs">
      <inertia-link href="/" class="font-bold text-indigo-700">Нүүр хуудас</inertia-link>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <span class="text-gray-600">Зөрчлийн бүртгэл</span>
    </div>
  </div>
  <div class="grid grid-cols-1 px-4 gap-4 mt-8 sm:grid-cols-2 sm:px-8">
    <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow">
      <h3 class="text-xl text-gray-600 mb-4 tracking-wider">Үндсэн мэдээлэл</h3>
      <RegisterCard :item="data" hideMoreButton @select="select"></RegisterCard>
    </div>
    <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow">
      <h3 class="text-xl text-gray-600 mb-4">Байрлал /Газрын зураг/</h3>
      <ShowMapPoint :key="'fucing' + data.id" :coordinate="[data.long, data.lat]"></ShowMapPoint>
    </div>
  </div>
  <div class="p-8">
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl p-6">
      <h1 class="mb-8 font-bold text-3xl">
        <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('admin.registers.index')">Зөрчлийн
          бүртгэл</inertia-link>
        <span class="text-indigo-400 font-medium">/</span>
        Дэлгэрэнгүй
      </h1>
      <div>
        <RegisterCard :item="data" hideMoreButton @select="select">
          <h5 class="text-xs text-black">Бүртгэсэн хүн:</h5>
          <p>- {{ data.reg_user.name }}</p>
          <h5 v-if="data.resolve_desc" class="text-xs text-black">Шийдвэрлэсэн хүн:</h5>
          <p v-if="data.resolve_desc" class="mb-3 font-normal text-gray-700 dark:text-gray-400">
            - {{ data.resolve_desc }}
          </p>
          <video v-if="data.attached_video?.path" width="320" height="240" controls>
            <source :src="data.attached_video.path" />

            <a :href="data.attached_video.path"> Бичлэг татах</a>
          </video>
        </RegisterCard>
        <Modal :show="!!selected" @close="() => (selected = null)">
          <img :src="selected" alt="" />
        </Modal>
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
import ShowMapPoint from "@/Components/ShowMapPoint.vue";
import RegisterCard from "@/Components/RegisterCard.vue";
import Modal from "@/Components/Modal.vue";

export default {
  metaInfo: { title: "Edit Registers" },
  components: {
    LoadingButton,
    NumberInput,
    MyInput,
    MySelect,
    ShowMapPoint,
    RegisterCard,
    Modal,
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
      selected: null,
    };
  },
  computed: {},
  methods: {
    select(v) {
      this.selected = v;
    },
  },
};
</script>
