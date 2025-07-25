<script setup>
  import { ChevronRightIcon } from "@heroicons/vue/24/outline";
  import { ref } from "@vue/reactivity";

  const props = defineProps({
    icon: Function,
    appendIcon: Object,
    text: String,
    href: String,
    counter: [String, Number],
    child: Boolean,
    parent: Boolean,
    children: [Object, Array],
  });
</script>

<template>
  <ILink :href="href" :class="{ 'ml-4': child }" class="flex items-center w-full gap-2 px-4 py-2 transition duration-300 rounded hover:bg-gray-700 hover:text-white">
    <component :is="icon" v-if="icon" class="w-5 h-5" />
    <span class="flex-grow">
      <slot>{{ text }}</slot>
    </span><span v-if="counter" class="ml-auto text-xs bg-gray-500 px-2 py-1 rounded-sm">{{ counter }}</span>
    <ChevronRightIcon v-if="parent" class="w-5 h-5 i-ri-arrow-right-s-line" />
    <div v-else-if="appendIcon" class="w-5 h-5" :class="appendIcon" />
  </ILink>
</template>

<style scoped></style>
