import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useIsOnlineStore = defineStore('IsOnline', () => {
    const isOnline = ref(true);

    const handleConnection = () => {
        if (navigator.onLine) {
            isOnline.value = true;
        } else {
            isOnline.value = false;
        }
    };

    const startListening = () => {
        window.addEventListener('online', handleConnection);
        window.addEventListener('offline', handleConnection);
        console.log('subscribeIsOnline');
    };

    return { isOnline, startListening };
});
