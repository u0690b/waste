<template>
  <div v-if="links.length > 3">
    <div class="flex flex-wrap justify-between -mb-1 lg:justify-center">
      <template v-for="(link, key) in links">
        <div v-if="link.url === null" :key="key" class="px-3 py-2 mb-1 mr-1 text-sm leading-4 text-gray-400 border rounded" v-html="link.label" />
        <inertia-link v-else-if="key==0||key==links.length-1" :key="`asd1_${key}`" class="px-3 py-2 mb-1 mr-1 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500" :class="{ 'bg-white': link.active }" :href="link.url" v-html="link.label" />
        <inertia-link v-else :key="`asd_${key}`" class="hidden px-3 py-2 mb-1 mr-1 text-sm leading-4 border rounded lg:flex hover:bg-white focus:border-indigo-500 focus:text-indigo-500" :class="{ 'bg-white': link.active }" :href="link.url" v-html="link.label" />
      </template>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    links: Array,
  },
}
</script>
