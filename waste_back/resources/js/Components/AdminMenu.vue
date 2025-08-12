<script setup>
  import {
    HomeIcon,
    BuildingLibraryIcon,
    WrenchScrewdriverIcon,
    UserGroupIcon,
    ClipboardDocumentCheckIcon,
    ChevronRightIcon,
    MapIcon,
    ChartBarIcon,
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
      href: "/dashboard",
    },
    {
      icon: markRaw(ChartBarIcon),
      text: "Тайлан",
      href: route("admin.tailan"),
    },
  ]);
  const settings = ref([]);
  const user = computed(() => usePage().props.auth.user);
  if (['admin', 'zaa'].includes(user.value.roles)) {
    menus.value.push(

      {
        text: "Хэрэглэгч",
        icon: markRaw(UserGroupIcon),
        href: route("admin.users.index"),
      },

    )
    settings.value.push(
      {
        text: "Өгөгдлийн сан",
        icon: markRaw(WrenchScrewdriverIcon),
        href: "#",
        children: [
          {
            text: "Хариуцах нэгж",
            icon: markRaw(ChevronRightIcon),
            href: route("admin.places.index"),
          },
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
          {
            text: "Хуулийн этгээд",
            icon: markRaw(ChevronRightIcon),
            href: route("admin.legal_entities.index"),
          },
          {
            text: "Үйл ажиллагааны чиглэл",
            icon: markRaw(ChevronRightIcon),
            href: route("admin.industries.index"),
          },
          {
            text: "Шийдвэрийн төрөл",
            icon: markRaw(ChevronRightIcon),
            href: route("admin.resolves.index"),
          },


        ],
      },
    )
  } else if (['da'].includes(user.value.roles)) {
    settings.value.push(
      {
        text: "Хэрэглэгч",
        icon: markRaw(UserGroupIcon),
        href: route("admin.users.index"),
      },

    )
  }

  const totalStat = computed(() => usePage().props.totalStat)
  const zurchil = [
    {
      text: "Зөрчлийн жагсаалт",
      icon: markRaw(ClipboardDocumentCheckIcon),
      href: route("admin.registers.index"),
      counter: totalStat.value.register
    },

    {
      text: "Зөрчлийн байрлал",
      icon: markRaw(MapIcon),
      href: route("register.map"),
    },
  ]
  // const InsItTul = computed(() => user.value.rolecodelist.includes('InsItTul'))	// baitsaagch
</script>

<template>
  <Backdrop v-if="isOpen" @click="isOpen = false" />

  <aside class="hidden w-64 bg-[#406f47] sm:block">
    <div class="py-3 pl-3 mb-8 tracking-widest text-center uppercase bg-[#406f47] border-gray-800 border-b-1">
      <img src="@/assets/icon-512.png" class="object-contain w-12 ... float-left" />
      <div class="py-2">
        <ILink href="/" class="p-4 text-white sm:w-2/3 lg:w-3/4 ">Dashboard</ILink>
      </div>
    </div>

    <!-- menu -->
    <nav class="text-sm text-gray-300">
      <ul class="flex flex-col">
        <li class="px-4 py-2 text-xs font-bold tracking-wider uppercase">Үндсэн цэс</li>
        <SidebarItem v-for="menu in menus" :key="menu.text" :menu="menu" class="px-4 py-2 text-xs font-bold tracking-wider text-white uppercase" />
        <li class="px-4 py-2 text-xs font-bold tracking-wider uppercase">Тохиргоо</li>
        <SidebarItem v-for="menu in settings" :key="menu.text" :menu="menu" class="px-4 py-2 text-xs font-bold tracking-wider text-white uppercase" />
        <li class="px-4 py-2 text-xs font-bold tracking-wider uppercase">Зөрчлийн мэдээлэл</li>
        <SidebarItem v-for="menu in zurchil" :key="menu.text" :menu="menu" class="px-4 py-2 text-xs font-bold tracking-wider text-white uppercase" />
      </ul>
    </nav>
  </aside>
</template>

<style scoped></style>
