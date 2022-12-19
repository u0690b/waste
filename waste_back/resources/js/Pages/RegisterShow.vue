<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <inertia-link @click="back">
      <h2 class="text-2xl text-gray-600 underline font-bold">Буцах</h2>
    </inertia-link>
  </div>
  <div class="grid grid-cols-1 px-4 gap-4 mt-8 sm:grid-cols-2 sm:px-8">
    <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow">
      <h3 class="text-xl text-gray-600 mb-4 tracking-wider">Үндсэн мэдээлэл</h3>
      <table class="min-w-full text-gray-500">
        <tbody>
          <tr>
            <td class="flex items-center py-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
              </svg>

              <div class="px-4">
                <div>Агуулга:</div>
                <div class="font-bold text-sm">
                  <a href="#"></a>
                </div>
              </div>
            </td>
            <td class="py-2 text-right">
              <div class="text-sm">dff</div>
            </td>
          </tr>
          <tr>
            <td class="flex items-center py-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
              </svg>

              <div class="px-4">
                <div>Зөрчлийн төрөл:</div>
                <div class="font-bold text-sm">
                  <a href="#"></a>
                </div>
              </div>
            </td>
            <td class="py-2 text-right">
              <div class="text-sm">{{ data.reason.name }}</div>
            </td>
          </tr>
          <tr>
            <td class="flex items-center py-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
              </svg>

              <div class="px-4">
                <div>Төлөв:</div>
                <div class="font-bold text-sm">
                  <a href="#"></a>
                </div>
              </div>
            </td>
            <td class="py-2 text-right">
              <div class="text-sm">{{ data.status.name }}</div>
            </td>
          </tr>
          <tr>
            <td class="flex items-center py-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
              </svg>

              <div class="px-4">
                <div>Хаяг:</div>
                <div class="font-bold text-sm">
                  <a href="#"></a>
                </div>
              </div>
            </td>
            <td class="py-2 text-right">
              <div class="text-sm">
                {{ data.aimag_city.name }}, {{ data.soum_district.name }},
                {{ data.bag_horoo.name }} {{ data.bag_horoo.name }}
              </div>
            </td>
          </tr>
          <tr>
            <td class="flex items-center py-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
              </svg>

              <div class="px-4">
                <div>Бүртгэсэн огноо:</div>
                <div class="font-bold text-sm">
                  <a href="#"></a>
                </div>
              </div>
            </td>
            <td class="py-2 text-right">
              <div class="text-sm">dff</div>
            </td>
          </tr>
          <tr>
            <td class="flex items-center py-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
              </svg>

              <div class="px-4">
                <div>Бүртгэсэн хүн:</div>
                <div class="font-bold text-sm">
                  <a href="#"></a>
                </div>
              </div>
            </td>
            <td class="py-2 text-right">
              <div class="text-sm">{{ data.reg_user.name }}</div>
            </td>
          </tr>
          <tr>
            <td class="flex items-center py-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
              </svg>

              <div class="px-4">
                <div>Гаргасан зөрчлийн байдал:</div>
                <div class="font-bold text-sm">
                  <a href="#"></a>
                </div>
              </div>
            </td>
            <td class="py-2 text-right">
              <div class="text-sm">{{ data.description }}</div>
            </td>
          </tr>
        </tbody>
      </table>
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
import GuestLayout from "@/Layouts/GuestLayout.vue";
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
  layout: GuestLayout,
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
    back() {
      window.history.back()
    }
  },
};
</script>
