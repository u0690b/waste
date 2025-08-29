<script setup lang="ts">
import NotificationButton from '@/components/My/NotificationButton.vue';
import NotInstalled from '@/components/My/NotInstalled.vue';
import { useFirebase } from '@/composables/firebase';
import { useCommonStore } from '@/composables/store';
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import {  onMounted, ref } from 'vue';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const commonStore = useCommonStore();
const tokenStore = useFirebase();

const isInstalled = ref(false);

onMounted(() => {
    commonStore.fetchData();

    isInstalled.value = window.matchMedia('(display-mode: standalone)').matches;
    window.matchMedia('(display-mode: standalone)').addEventListener('change', (evt) => {
        if (evt.matches) {
            isInstalled.value = true;
        }
    });
});
// Request Notification Permission

// Listen foreground messages
tokenStore.onMsg((payload: any) => {
    console.log('Message received in foreground:', payload);
    alert(payload.notification?.title || 'New Notification');
});

</script>

<template>
    <NotInstalled v-if="!isInstalled" />
    <UApp v-else :toaster="{ position: 'top-right' }">
        <AppLayout  :breadcrumbs="breadcrumbs" class="bg-default max-md:pb-22" data-vaul-drawer-wrapper>
            <template #actionSide>
                <NotificationButton />
            </template>
            <slot />
        </AppLayout>
    </UApp>
</template>
