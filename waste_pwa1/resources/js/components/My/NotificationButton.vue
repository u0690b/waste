<script setup lang="ts">
// import { useFirebase } from '@/composables/firebase';
import { router, usePage } from '@inertiajs/vue3';
import { Bell, BellOff } from 'lucide-vue-next';
import { computed } from 'vue';

const page = usePage();
const noti = computed(() => page.props.new_noti ?? 0);
// const tokenStore = useFirebase();
const isPermitted = computed(() => Notification.permission === 'granted');
const onCLick = () => {
    // tokenStore.requestPermission();
    router.visit(route('notifications'));
    console.log('Notification button clicked');
};

</script>

<template>
    <UChip :text="noti" :show="noti !== 0">
        <button  @click="onCLick" class="rounded-md bg-neutral-300 p-1 hover:bg-neutral-400">
            <Bell v-if="isPermitted "  class="text-neutral-500" :size="18" />
            <BellOff v-else class="text-neutral-500" :size="18" />
        </button>
    </UChip>
</template>
