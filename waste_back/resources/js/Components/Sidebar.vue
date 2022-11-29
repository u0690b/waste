<script  setup>

import { HomeIcon, PaperClipIcon, DocumentMagnifyingGlassIcon, DocumentChartBarIcon } from '@heroicons/vue/24/outline'
import Backdrop from './Backdrop.vue'
import SidebarItem from './SidebarItem.vue'
import { toRefs, ref, watch, markRaw, h } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'
import { computed } from '@vue/reactivity'
const props =
  defineProps({
    modelValue: { type: Boolean, default: false },
  })

const { modelValue } = toRefs(props)

const emit = defineEmits(['update:modelValue'])

const isOpen = ref(props.modelValue)

watch(
  modelValue,
  (val) => {
    isOpen.value = val
  },
  { immediate: true },
)

watch(isOpen, (val) => {
  emit('update:modelValue', val)
})

const menus = ref([
  {
    icon: markRaw(HomeIcon),
    text: 'Нүүр хуудас',
    href: '/',
  },
  {
    text: 'Commons',
    icon: markRaw(PaperClipIcon),
    href: '#',
    children: [


      {
        text: 'Places',
        icon: markRaw(PaperClipIcon),
        href: route('admin.places.index'),
      },
      {
        text: 'Reasons',
        icon: markRaw(PaperClipIcon),
        href: route('admin.reasons.index'),
      },
      {
        text: 'Statuses',
        icon: markRaw(PaperClipIcon),
        href: route('admin.statuses.index'),
      },

      {
        text: 'Aimag Cities',
        icon: markRaw(PaperClipIcon),
        href: route('admin.aimag_cities.index'),
      },
      {
        text: 'Soum Districts',
        icon: markRaw(PaperClipIcon),
        href: route('admin.soum_districts.index'),
      },
      {
        text: 'Bag Horoos',
        icon: markRaw(PaperClipIcon),
        href: route('admin.bag_horoos.index'),
      },
      {
        text: 'Users Models',
        icon: markRaw(PaperClipIcon),
        href: route('admin.users.index'),
      },
    ]
  },

  {
    text: 'Registers',
    icon: markRaw(PaperClipIcon),
    href: route('admin.registers.index'),
  },


])

const user = computed(() => usePage().props.value.auth.user)
// const InsItTul = computed(() => user.value.rolecodelist.includes('InsItTul'))	// baitsaagch


</script>

<template>
  <Backdrop v-if="isOpen" @click="isOpen = false" />

  <aside
    class="px-2 w-10/12 sm:w-[300px] border-r h-screen fixed top-0 border-gray-200 pb-2 bg-white z-10 flex-col transition-all duration-300 transform sm:transform-none"
    :class="isOpen ? 'translate-x-0' : '-translate-x-full'">
    <!-- nav header -->
    <div class="flex items-center justify-between gap-2 px-4 -mx-2 border-b border-gray-200 sm:border-none ">
      <inertia-link href="/"
        class="flex items-center justify-between w-full gap-2 py-5 text-lg font-bold text-indigo-500 sm:justify-center">
        <div class="flex items-center justify-center gap-2">
          <img src="/assets/img/logo.png" alt="" class="h-20" />
          <div class="text-gray-500 font-bold uppercase">
            Хог хаягдалын бүртгэл
          </div>
        </div>
      </inertia-link>
      <button class="inline w-6 h-6 i-ri-close-line text sm:hidden" @click="isOpen = false" />
    </div>

    <!-- menu -->
    <ul class="flex-grow">
      <SidebarItem v-for="menu in menus" :key="menu.text" :menu="menu" />
    </ul>
  </aside>
</template>

<style scoped>

</style>
