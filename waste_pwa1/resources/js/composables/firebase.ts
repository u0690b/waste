// src/firebase.js
import axios from 'axios';
import { initializeApp } from 'firebase/app';
import { getMessaging, getToken, MessagePayload, NextFn, Observer, onMessage } from 'firebase/messaging';
import { defineStore } from 'pinia';
import { ref } from 'vue';
const firebaseConfig = {
    apiKey: 'AIzaSyAChRTzngj_dbz-XttiaIQN2m1fkrv12XM',
    authDomain: 'waste-project-49d6d.firebaseapp.com',
    projectId: 'waste-project-49d6d',
    messagingSenderId: '759328300749',
    appId: '1:759328300749:web:61cf7919884be1ca7b1384',
    measurementId: 'G-S1NQRYVRED',
};

// Init Firebase
const app = initializeApp(firebaseConfig);

// Init Messaging
const messaging = getMessaging(app);
const vapidKey = 'BOfqIP7ovgHpNWUtnPOtWqVDMgtbsJTdbRKjD3-QVZ88y7X3nGruKjYqvRREcaPZul7CnZKGIZL0eIdR48im1QM';

export const useFirebase = defineStore('firebase', () => {
    const token = ref<string>();
    const isAdded = ref<boolean>(false);
    const checkPremisstion = () => {
        if (Notification.permission !== 'granted' && !isAdded.value) {

            const toast = useToast();
            toast.add({
                title: 'Notification permission',
                description: 'Үйлдэлийн системийн тохиргооны Premissions цэснээс /Notification/ зөвшөөрнө үү',
            });
            isAdded.value = true;
            console.warn('Permission not granted for notifications');
        }
    };

    async function requestPermission() {
        if (!token.value) {
            const permission = await Notification.requestPermission();
            if (permission === 'granted') {
                try {
                    token.value = await getToken(messaging, { vapidKey });
                    axios.post(route('save_token'), { push_token: token.value });
                    // 👉 Send token to backend so you can push notifications
                } catch (err) {
                    console.error('Token error:', err);
                }
            } else {
                checkPremisstion();
                console.warn('Permission not granted for notifications');
            }
        }
    }

    const onMsg = (callback: NextFn<MessagePayload> | Observer<MessagePayload>) => onMessage(messaging, callback);
    return { requestPermission, onMsg, checkPremisstion };
});
