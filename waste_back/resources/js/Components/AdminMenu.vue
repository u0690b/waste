<script setup>
import {
  ArrowDownLeftIcon,
  EyeIcon,
  HomeIcon,
  KeyIcon,
  MinusSmallIcon,
  PaperClipIcon,
  BuildingLibraryIcon,
  WrenchScrewdriverIcon,
  UserGroupIcon,
  PhotoIcon,
  ListBulletIcon,
  ClipboardDocumentCheckIcon,
  ChevronRightIcon,
  TrashIcon,
} from "@heroicons/vue/24/outline";
import Backdrop from "./Backdrop.vue";
import SidebarItem from "./SidebarItem.vue";
import { toRefs, ref, watch, markRaw, h } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { computed } from "@vue/reactivity";
const props = defineProps({
  modelValue: { type: Boolean, default: false },
});

const { modelValue } = toRefs(props);

const emit = defineEmits(["update:modelValue"]);

const isOpen = ref(props.modelValue);

watch(
  modelValue,
  (val) => {
    isOpen.value = val;
  },
  { immediate: true }
);

watch(isOpen, (val) => {
  emit("update:modelValue", val);
});

const menus = ref([
  {
    icon: markRaw(HomeIcon),
    text: "Нүүр хуудас",
    href: "/",
  },
  {
    text: "Байгууллага",
    icon: markRaw(BuildingLibraryIcon),
    href: route("admin.places.index"),
  },
  {
    text: "Хэрэглэгч",
    icon: markRaw(UserGroupIcon),
    href: route("admin.users.index"),
  },
  {
    text: "Тохиргоо",
    icon: markRaw(WrenchScrewdriverIcon),
    href: "#",
    children: [
      {
        text: "Шалтгаан",
        icon: markRaw(ChevronRightIcon),
        href: route("admin.reasons.index"),
      },
      {
        text: "Төлөв",
        icon: markRaw(ChevronRightIcon),
        href: route("admin.statuses.index"),
      },

      {
        text: "Аймаг/нийслэл",
        icon: markRaw(ChevronRightIcon),
        href: route("admin.aimag_cities.index"),
      },
      {
        text: "Сум/дүүрэг",
        icon: markRaw(ChevronRightIcon),
        href: route("admin.soum_districts.index"),
      },
      {
        text: "Баг/хороо",
        icon: markRaw(ChevronRightIcon),
        href: route("admin.bag_horoos.index"),
      },
    ],
  },

  {
    text: "Зөрчил бүртгэл",
    icon: markRaw(ClipboardDocumentCheckIcon),
    href: route("admin.registers.index"),
  },
  {
    text: "Файлын сан",
    icon: markRaw(PhotoIcon),
    href: route("admin.registers.index"),
  },
]);

const user = computed(() => usePage().props.value.auth.user);
// const InsItTul = computed(() => user.value.rolecodelist.includes('InsItTul'))	// baitsaagch
</script>

<template>
  <Backdrop v-if="isOpen" @click="isOpen = false" />

  <aside class="hidden w-64 bg-gray-800 sm:block">
    <div
      class="py-3 text-1xl uppercase text-center tracking-widest bg-gray-900 border-b-2 border-gray-800 mb-8"
    >
      <inertia-link href="/" class="text-white">WASTE MONITORING</inertia-link>
    </div>

    <!-- menu -->
    <nav class="text-sm text-gray-300">
      <ul class="flex flex-col">
        <SidebarItem
          v-for="menu in menus"
          :key="menu.text"
          :menu="menu"
          class="px-4 py-2 text-xs uppercase tracking-wider text-gray-500 font-bold"
        />
      </ul>
    </nav>
  </aside>
</template>

<style scoped></style>
