<script setup lang="ts">
import { useFirebase } from '@/composables/firebase';
import { useCommonStore } from '@/composables/store';
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { Bell } from 'lucide-vue-next';
import { computed, onMounted } from 'vue';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});



const commonStore = useCommonStore();
const tokenStore = useFirebase();
onMounted(()=>{
    commonStore.fetchData()
    tokenStore.requestPermission()
})
// Request Notification Permission

// Listen foreground messages
tokenStore.onMsg((payload:any) => {
    console.log("Message received in foreground:", payload);
    alert(payload.notification?.title || "New Notification");
});

const page = usePage()
const noti = computed(()=>page.props.new_noti??0)
</script>

<template>
    <UApp :toaster="{position:'top-right'}">
        <AppLayout :breadcrumbs="breadcrumbs" class="bg-default max-md:pb-22 " data-vaul-drawer-wrapper>
            <template #actionSide>
                <UChip :text="noti" :show="noti!==0">
                    <ULink to="/notifications" class="bg-neutral-300 rounded-md p-1">
                        <Bell class="text-neutral-500" :size="18" />
                    </ULink>
                </UChip>
            </template>
            <slot />
        </AppLayout>
    </UApp>
</template>
