<script setup lang="ts">


import { useColorMode } from '@vueuse/core'
import { computed } from 'vue'

const colorMode = useColorMode()

const isDark = computed({
  get() {
    return colorMode.value === 'dark'
  },
  set(_isDark) {
    colorMode.value = _isDark ? 'dark' : 'light'
  }
})
</script>

<template>
  
    <UButton
      :icon="isDark ? 'i-lucide-moon' : 'i-lucide-sun'"
      color="neutral"
      variant="ghost"
      class="dark:bg-gray-800 dark:text-white"
      @click="isDark = !isDark"
    />

   
  
</template>
