<template>
  <main class="">
    <!-- <Sidebar v-model="sidebar" /> -->
    <!-- <NavDrawer /> -->
<AdminMenu class="float-left"></AdminMenu>
    <div class="sm:ml-[300px]">
      <!-- <Header @menu:click="sidebar = true" /> -->

      <!-- main content -->
      <!-- <FlashMessages :errors="errors" /> -->
      <div class="px-6 py-6">
        <slot />
      </div>
    </div>
  </main>
</template>
<script setup>
import AdminMenu from '@/Components/AdminMenu.vue';
import FlashMessages from '@/Components/FlashMessages.vue'
// import Sidebar from '@/Components/Dashboard/Sidebar.vue'
// import Header from '@/Components/Dashboard/Header.vue'
import { ref } from 'vue'

const props =defineProps({errors:{type:Object,default:()=>({})}})
const sidebar = ref(false)


</script>
