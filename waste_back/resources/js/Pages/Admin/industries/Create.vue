<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <h2 class="text-xl text-gray-600">
      <ILink class="text-gray-600 hover:text-gray-600  font-bold flex" :href="route('admin.industries.index')">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
        </svg>
        Үйл ажиллагааны чиглэл бүртгэл
      </ILink>
    </h2>
    <div class="flex items-center space-x-1 text-xs">
      <ILink href="/" class="font-bold text-indigo-700 text-sm">Нүүр хуудас</ILink>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <span class="text-gray-600 text-sm">Үйл ажиллагааны чиглэл бүртгэл</span>
    </div>
  </div>
  <div class="p-4 mt-8 sm:px-8 sm:py-4">
    <div class="p-4 bg-white flex flex-col items-center justify-center rounded">
      <div class="bg-white rounded shadow w-2/5">
        <form @submit.prevent="submit">
          <div class="p-8 -mr-6 -mb-8 flex-wrap">
            <MyInput v-model="form.name" type="text" :error="errors.name" class="" label="Үйл Ажиллагааны Чиглэл" />
          </div>
          <div class="flex justify-center">
            <button :loading="form.processing" class="flex bg-gray-600 p-3 my-3 text-white rounded text-base hover:bg-gray-500" type="submit">
              Хадгалах
            </button>
            <button :loading="form.processing" class="flex bg-gray-600  p-3 mx-4 my-3 text-white rounded text-base hover:bg-gray-500">
              <ILink class="text-white hover:text-white" :href="route('admin.industries.index')">
                Буцах</ILink>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

</template>

<script>
  import Layout from '@/Layouts/Admin.vue'
  import LoadingButton from '@/Components/LoadingButton.vue'
  import NumberInput from '@/Components/MyInput.vue'
  import MyInput from '@/Components/MyInput.vue'

  export default {
    metaInfo: { title: 'Create Industries' },
    components: {
      LoadingButton,
      NumberInput,
      MyInput,
    },
    layout: Layout,
    props: {
      errors: Object,
      data: Object,
      host: String,
    },
    data() {
      return {
        form: this.$inertia.form({
          id: null,
          name: null,
        }),
      }
    },
    methods: {
      submit() {
        this.form.post(this.route('admin.industries.store'))
      },
    },
  }
</script>
