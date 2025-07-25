// web/firebase-messaging-sw.js
importScripts('https://www.gstatic.com/firebasejs/10.11.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.11.0/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: "AIzaSyAChRTzngj_dbz",
    authDomain: "waste-project-49d6d.firebaseapp.com",
    projectId: "waste-project-49d6d",
    messagingSenderId: "759328300749",
    appId: "1:759328300749:web:c9dfa2e2ce16b10a7b1384"
});



const messaging = firebase.messaging();

messaging.onBackgroundMessage(async (payload) => {
    console.log('Received background message:', payload);

    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: '/icons/Icon-192.png',
        badge: '/icons/Icon-192.png',
        data: payload.data,
        click_action: payload.notification.click_action || '/mobile',
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});