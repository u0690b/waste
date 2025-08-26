<script setup lang="ts">
import ColorModeButton from '@/components/ColorModeButton.vue';
import NotInstalled from '@/components/My/NotInstalled.vue';
import AuthLayout from '@/layouts/auth/AuthSimpleLayout.vue';
import { onMounted, ref } from 'vue';

defineProps<{
    title?: string;
    description?: string;
}>();
const isInstalled = ref(false);

onMounted(() => {
    isInstalled.value = window.matchMedia('(display-mode: standalone)').matches;
    window.matchMedia('(display-mode: standalone)').addEventListener('change', (evt) => {
        if (evt.matches) {
            isInstalled.value = true;
        }
    });
});
</script>

<template>
    <div class="min-h-screen">
        <ColorModeButton></ColorModeButton>

        <AuthLayout :title="title" :description="description">
            <NotInstalled v-if="!isInstalled" />
            <slot v-else />
        </AuthLayout>
    </div>
</template>
