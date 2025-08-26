<script setup lang="ts">
import NotInstalled from '@/components/My/NotInstalled.vue';
import { useFirebase } from '@/composables/firebase';
import { useCommonStore } from '@/composables/store';
import { useIsOnlineStore } from '@/composables/useIsOnline';
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { Bell } from 'lucide-vue-next';
import { computed, onMounted, ref } from 'vue';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const commonStore = useCommonStore();
const tokenStore = useFirebase();
const isOnlineStore = useIsOnlineStore();

const isInstalled = ref(false);

onMounted(() => {
    commonStore.fetchData();
    tokenStore.requestPermission();
    isInstalled.value = window.matchMedia('(display-mode: standalone)').matches;
    window.matchMedia('(display-mode: standalone)').addEventListener('change', (evt) => {
        if (evt.matches) {
            isInstalled.value = true;
        }
    });
    isOnlineStore.startListening();
});
// Request Notification Permission

// Listen foreground messages
tokenStore.onMsg((payload: any) => {
    console.log('Message received in foreground:', payload);
    alert(payload.notification?.title || 'New Notification');
});

const page = usePage();
const noti = computed(() => page.props.new_noti ?? 0);
</script>

<template>
    <UApp :toaster="{ position: 'top-right' }">

        <NotInstalled v-if="!isInstalled" />

        <AppLayout v-else :breadcrumbs="breadcrumbs" class="bg-default max-md:pb-22" data-vaul-drawer-wrapper>
            <template #actionSide>
                <UChip :text="noti" :show="noti !== 0">
                    <ILink :href="route('notifications')" class="rounded-md bg-neutral-300 p-1 hover:bg-neutral-400">
                        <Bell class="text-neutral-500" :size="18" />
                    </ILink>
                </UChip>
            </template>
            <slot />
        </AppLayout>
    </UApp>
</template>
