<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div>
        <Link href="/" class="flex flex-col items-center gap-2 font-medium">
            <img src="@/assets/logo.png" class="rounded-full w-34 h-34 mx-auto mb-10" alt="Logo">
        </Link>
        <slot />
    </div>
</template>
