<script setup>
import SidebarLink from "./SidebarLink.vue";
import { ref } from "vue";
import { ChevronRightIcon } from "@heroicons/vue/24/outline";
const props = defineProps({
  menu: Object,
});

const isOpen = ref(false);
</script>

<template>
  <li>
    <SidebarLink v-if="menu.href != '#'" v-bind="menu" :parent="!!menu['children']" @click="isOpen = !isOpen"
      :class="{ '!bg-indigo-500': route().current(menu.href) }" />
    <a v-else :parent="!!menu['children']"
      class="flex items-center w-full gap-2 px-4 py-2 transition duration-300 rounded hover:bg-indigo-500 hover:text-white"
      @click="isOpen = !isOpen">
      <component :is="menu.icon" class="w-5 h-5" />
      <span class="flex-grow">
        <slot>{{ menu.text }}</slot>
      </span>
      <ChevronRightIcon class="w-5 h-5 i-ri-arrow-right-s-line" />
    </a>
    <ul v-if="menu['children']" :class="isOpen ? 'block' : 'hidden'">
      <li v-for="child in menu['children']" :key="child.text">
        <SidebarLink v-bind="child" child />
      </li>
    </ul>
  </li>
</template>

<style scoped>

</style>
