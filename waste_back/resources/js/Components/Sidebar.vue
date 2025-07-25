<script setup>
  import {
    HomeIcon,
    PaperClipIcon,
    DocumentMagnifyingGlassIcon,
    DocumentChartBarIcon,
  } from "@heroicons/vue/24/outline";
  import Backdrop from "./Backdrop.vue";
  import SidebarItem from "./SidebarItem.vue";
  import { toRefs, ref, watch, markRaw, h } from "vue";
  import { usePage } from "@inertiajs/vue3";
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
          text: "Хог хаягдлын бүлэг",
          icon: markRaw(PaperClipIcon),
          href: route("admin.places.index"),
        },
        {
          text: "Шалтгаан",
          icon: markRaw(PaperClipIcon),
          href: route("admin.reasons.index"),
        },
        {
          text: "Төлөв",
          icon: markRaw(PaperClipIcon),
          href: route("admin.statuses.index"),
        },

        {
          text: "Аймаг/нийслэл",
          icon: markRaw(PaperClipIcon),
          href: route("admin.aimag_cities.index"),
        },
        {
          text: "Сум/дүүрэг",
          icon: markRaw(PaperClipIcon),
          href: route("admin.soum_districts.index"),
        },
        {
          text: "Баг/хороо",
          icon: markRaw(PaperClipIcon),
          href: route("admin.bag_horoos.index"),
        },
        {
          text: "Хэрэглэгч",
          icon: markRaw(PaperClipIcon),
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

  const user = computed(() => usePage().props.auth.user);
  // const InsItTul = computed(() => user.value.rolecodelist.includes('InsItTul'))	// baitsaagch
</script>

<template>
  <Backdrop v-if="isOpen" @click="isOpen = false" />

  <aside class="hidden w-64 bg-gray-800 sm:block" :class="isOpen ? 'translate-x-0' : '-translate-x-full'">
    <div class="py-3 mb-8 text-2xl tracking-widest text-center uppercase bg-gray-900 border-b-2 border-gray-800">
      <ILink href="/" class="text-white">Tailmin</ILink>
    </div>

    <!-- menu -->
    <nav class="text-sm text-gray-300">
      <ul class="flex flex-col">
        <SidebarItem v-for="menu in menus" :key="menu.text" :menu="menu" class="px-4 py-2 text-xs font-bold tracking-wider text-gray-500 uppercase" />
      </ul>
    </nav>
  </aside>
</template>

<style scoped></style>
