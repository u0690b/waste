<script setup>
import {
  ArrowDownLeftIcon,
  EyeIcon,
  HomeIcon,
  KeyIcon,
  MinusSmallIcon,
  PaperClipIcon,
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
    text: "Тохиргоо",
    icon: markRaw(PaperClipIcon),
    href: "#",
    children: [
      {
        text: "Байгууллага",
        icon: markRaw(MinusSmallIcon),
        href: route("admin.places.index"),
      },
      {
        text: "Шалтгаан",
        icon: markRaw(MinusSmallIcon),
        href: route("admin.reasons.index"),
      },
      {
        text: "Төлөв",
        icon: markRaw(MinusSmallIcon),
        href: route("admin.statuses.index"),
      },

      {
        text: "Аймаг/нийслэл",
        icon: markRaw(MinusSmallIcon),
        href: route("admin.aimag_cities.index"),
      },
      {
        text: "Сум/дүүрэг",
        icon: markRaw(MinusSmallIcon),
        href: route("admin.soum_districts.index"),
      },
      {
        text: "Баг/хороо",
        icon: markRaw(MinusSmallIcon),
        href: route("admin.bag_horoos.index"),
      },
      {
        text: "Хэрэглэгч",
        icon: markRaw(MinusSmallIcon),
        href: route("admin.users.index"),
      },
    ],
  },

  {
    text: "Бүртгэл",
    icon: markRaw(PaperClipIcon),
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
