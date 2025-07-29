<template>
  <main class="flex min-h-screen">
    <!-- <Sidebar v-model="sidebar" /> -->
    <AdminMenu></AdminMenu>
    <!-- <NavDrawer /> -->
    <div class="flex flex-col flex-grow ">
      <TheHeader />

      <!-- main content -->
      <!-- <FlashMessages :errors="errors" /> -->
      <div class="mb-auto">
        <slot />
      </div>
      <TheFooter />
    </div>
  </main>
</template>
<script setup>
  import AdminMenu from "@/Components/AdminMenu.vue";
  import FlashMessages from "@/Components/FlashMessages.vue";
  import Sidebar from "@/Components/Sidebar.vue";
  import TheFooter from "@/Components/TheFooter.vue";
  import TheHeader from "@/Components/TheHeader.vue";
  // import Header from '@/Components/Dashboard/Header.vue'
  import { ref } from "vue";

  const props = defineProps({ errors: { type: Object, default: () => ({}) } });
  const sidebar = ref(false);
</script>
