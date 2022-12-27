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
      :class="{ '!bg-gray-700': route().current(menu.href) }" />

    <a v-else :parent="!!menu['children']"
      class="flex items-center w-full gap-2 px-4 py-2 transition duration-300 rounded hover:bg-gray-700 hover:text-white"
      @click="isOpen = !isOpen">
      <component :is="menu.icon" class="w-5 h-5" />
      <span class="flex-grow">
        <slot>{{ menu.text }}</slot>
      </span>
      <span v-if="menu.counter" class="ml-auto text-xs bg-gray-500 px-2 py-1 rounded-sm">{{ menu.counter }}</span>
      <ChevronRightIcon class="w-5 h-5 i-ri-arrow-right-s-line" />
    </a>
    <ul v-if="menu['children']" :class="isOpen ? 'block' : ''">
      <li v-for="child in menu['children']" :key="child.text">
        <SidebarLink v-bind="child" child />
      </li>

    </ul>
  </li>
</template>

<style scoped>

</style>
