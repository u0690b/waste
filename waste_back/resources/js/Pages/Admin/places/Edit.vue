<template>
  <Layout :title="title">
    <div class="p-4 mt-8 sm:px-8 sm:py-4 ">
      <div class="p-4 bg-white rounded shadow">
        <h1><BackButton href="/admin/places" />{{ title }}</h1>
        <Fields :data="data" @save="submit"></Fields>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from "@/Layouts/Admin.vue";
import BackButton from '@/Components/BackButton.vue';
import Fields from "./Fields.vue";

const title = 'Хог хаягдлын бүлэг Засах'

const props = defineProps({
  data: [Object],
})

/**
 * Inertia Form
 * @constructor
 * @param {import("@inertiajs/vue3").InertiaForm} form - inertia form.
 */
const submit = (form) => {
  form.put('/admin/places/'+props.data.id, {
    headers: { back: new URLSearchParams(window.location.search).get("callback")},
    preserveScroll: true,
    replace: true,
    onSuccess: () => form.reset(),
    onError: () => ({}),
    onFinish: () => ({}),
  });
};
</script>

