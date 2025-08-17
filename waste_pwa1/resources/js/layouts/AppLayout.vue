<script setup lang="ts">
import { useCommonStore } from '@/composables/store';
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { onMounted } from 'vue';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}
const commonStore = useCommonStore();
onMounted(()=>{
    commonStore.fetchData()
})
withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs" class="bg-default"  data-vaul-drawer-wrapper>
        <slot />
    </AppLayout>
</template>
