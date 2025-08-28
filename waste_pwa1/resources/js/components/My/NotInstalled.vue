<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';

const deferredPrompt = ref(null);
const showInstallButton = ref(false);
const isInstalled = ref(false);
onMounted(() => {
    window.addEventListener('beforeinstallprompt', function (e: Event) {
        e.preventDefault();
        deferredPrompt.value = e ;
        showInstallButton.value = true;
    });
    isInstalled.value = window.matchMedia('(display-mode: standalone)').matches;
    window.matchMedia('(display-mode: standalone)').addEventListener('change', (evt) => {
        if (evt.matches) {
            isInstalled.value = true;
        }
    });
});
const onInstall = () => {
    if (!deferredPrompt.value) return;
    deferredPrompt.value.prompt();
    deferredPrompt.value.userChoice.then((choiceResult) => {
        if (choiceResult.outcome === 'accepted') {
            console.log('User accepted the install prompt');
        } else {
            console.log('User dismissed the install prompt');
        }
        deferredPrompt.value = null;
        showInstallButton.value = false;
    });

};

const isIos = computed(() => {
    const userAgent = window.navigator.userAgent.toLowerCase();
    return /iphone|ipad|ipod/.test(userAgent);
});
</script>

<template>
    <div class="p-4">
        <div v-if="!isIos" class="flex">
            <UButton v-if="showInstallButton" @click="onInstall" class="mx-auto">Суулгах</UButton>
        </div>
        <div v-if="isIos">
            <h1 class="text-center">IOS дээр суулгах заавар</h1>
            <img src="@/assets/ios_add.png" class="mx-auto w-96" />
        </div>
         <div v-else-if="!isInstalled && showInstallButton">
            <h1 class="text-center">Програм суулгах заавар</h1>
            <img src="@/assets/and_add.png" class="mx-auto w-96" />
        </div>
        <div v-if="!showInstallButton" class="text-center">
            <a href="/mobile/?source=pwa" target="_blank">Энд дарж програмаар орох</a>
        </div>
    </div>
</template>
<style lang="css">
.ios-install-guide {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}
.ios-install-guide img {
    max-width: 90%;
    margin-bottom: 1rem;
}
.ios-install-guide button {
    padding: 0.5rem 1rem;
    background: #42b983;
    border: none;
    color: white;
    font-size: 1rem;
    cursor: pointer;
}
</style>
