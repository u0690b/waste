<script setup lang="ts">
import { useFirebase } from '@/composables/firebase';
import { onMounted } from 'vue';





const tokenStore = useFirebase();


onMounted(() => {
    tokenStore.requestPermission();
});

</script>

<template>
    <slot />
</template>
