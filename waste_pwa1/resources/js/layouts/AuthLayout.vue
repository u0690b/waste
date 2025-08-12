<script setup lang="ts">
import ColorModeButton from '@/components/ColorModeButton.vue';
import AuthLayout from '@/layouts/auth/AuthSimpleLayout.vue';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <ColorModeButton></ColorModeButton>
    <AuthLayout :title="title" :description="description">
        <slot />
    </AuthLayout>
</template>
