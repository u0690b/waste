<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';


const page = usePage();


const flash = computed(()=>page.props.flash);


</script>
<template>
    <UAlert title="Heads up!" :description="flash.error" />

</template>
