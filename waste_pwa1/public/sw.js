const staticCacheName = 'waste-static-v2';
const assets = [
    '/',
    '/create',
    '/draft',
    '/send',
    '/solved',
    '/offline',
    '/settings/appearance',
    '/api/common',
    '/build/manifest.json',
    '/build/logo1.png',
    '/build/logo.png',
    '/build/app.css',
    '/build/app.js',
];

// install event
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(staticCacheName).then((cache) => {
            let cc = cache.addAll(assets);
            console.log('cheched');
            return cc;
        }),
    );
});

// Activate: cleanup old caches
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) =>
            Promise.all(
                cacheNames.map((cache) => {
                    if (cache !== staticCacheName) {
                        return caches.delete(cache);
                    }
                }),
            ),
        ),
    );
});

self.addEventListener('fetch', function (event) {
    event.respondWith(
        caches.open(staticCacheName).then(function (cache) {
            return fetch(event.request)
                .then(function (response) {
                    console.log('from network', event.request);
                    cache.put(event.request, response.clone());
                    return response;
                })
                .catch(function () {
                    console.log('from cache', event.request);
                    return caches.match(event.request).catch(function () {
                        // If both fail, show a generic fallback:
                        return caches.match('/offline');
                        // However, in reality you'd have many different
                        // fallbacks, depending on URL and headers.
                        // Eg, a fallback silhouette image for avatars.
                    });
                });
        }),
    );
});

// web/firebase-messaging-sw.js
importScripts('https://www.gstatic.com/firebasejs/10.11.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.11.0/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: 'AIzaSyAChRTzngj_dbz-XttiaIQN2m1fkrv12XM',
    authDomain: 'waste-project-49d6d.firebaseapp.com',
    projectId: 'waste-project-49d6d',
    messagingSenderId: '759328300749',
    appId: '1:759328300749:web:61cf7919884be1ca7b1384',
    measurementId: 'G-S1NQRYVRED',
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
