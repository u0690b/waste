// web/firebase-messaging-sw.js
importScripts('https://www.gstatic.com/firebasejs/10.11.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.11.0/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: 'AIzaSyAChRTzngj_dbz',
    authDomain: 'waste-project-49d6d.firebaseapp.com',
    projectId: 'waste-project-49d6d',
    messagingSenderId: '759328300749',
    appId: '1:759328300749:web:c9dfa2e2ce16b10a7b1384',
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(async (payload) => {
    console.log('Received background message:', payload);

    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: '/mobile/icons/Icon-192.png',
        badge: '/mobile/icons/Icon-192.png',
        data: payload.data,
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});

self.addEventListener('notificationclick', (event) => {
    console.log('[Firebase SW] Notification Clicked:', event);
    event.notification.close();

    const url = 'https://waste.mecc.gov.mn/mobile/';
    const nUrl = 'https://waste.mecc.gov.mn/mobile/notifications';
    if (url) {
        event.waitUntil(
            clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clientList) => {
                for (const client of clientList) {
                    console.log('window url:', client.url);
                    if (client.url.startsWith(url) && 'focus' in client) {
                        client.url = nUrl;
                        return client.focus();
                    }
                }
                if (clients.openWindow) {
                    return clients.openWindow(nUrl);
                }
            }),
        );
    }
});
