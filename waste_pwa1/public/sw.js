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
    '/build/assets/logo1-v2.png',
    '/build/assets/logo-v2.png',
    '/build/assets/app-v2.css',
    '/build/assets/WasteStore-v2.js',
    '/build/assets/loader-circle-v2.js',
    '/build/assets/usePortal-v2.js',
    '/build/assets/HeadingSmall.vue_vue_type_script_setup_true_lang-v2.js',
    '/build/assets/WasteDetail-v2.js',
    '/build/assets/useKbd-v2.js',
    '/build/assets/TextLink.vue_vue_type_script_setup_true_lang-v2.js',
    '/build/assets/Label-v2.js',
    '/build/assets/embla-carousel-auto-height.esm-v2.js',
    '/build/assets/useForwardExpose-v2.js',
    '/build/assets/Separator-v2.js',
    '/build/assets/AuthLayout.vue_vue_type_script_setup_true_lang-v2.js',
    '/build/assets/Send-v2.js',
    '/build/assets/Card-v2.js',
    '/build/assets/Solved-v2.js',
    '/build/assets/useLocale-v2.js',
    '/build/assets/Login-v2.js',
    '/build/assets/VerifyEmail-v2.js',
    '/build/assets/embla-carousel-class-names.esm-v2.js',
    '/build/assets/ConfirmPassword-v2.js',
    '/build/assets/Layout.vue_vue_type_script_setup_true_lang-v2.js',
    '/build/assets/Label.vue_vue_type_script_setup_true_lang-v2.js',
    '/build/assets/ForgotPassword-v2.js',
    '/build/assets/Draft-v2.js',
    '/build/assets/embla-carousel-autoplay.esm-v2.js',
    '/build/assets/embla-carousel-auto-scroll.esm-v2.js',
    '/build/assets/ResetPassword-v2.js',
    '/build/assets/Appearance-v2.js',
    '/build/assets/embla-carousel-fade.esm-v2.js',
    '/build/assets/Dashboard-v2.js',
    '/build/assets/Register-v2.js',
    '/build/assets/Password-v2.js',
    '/build/assets/WasteDetail.vue_vue_type_script_setup_true_lang-v2.js',
    '/build/assets/index-v2.js',
    '/build/assets/embla-carousel-wheel-gestures.esm-v2.js',
    '/build/assets/Profile-v2.js',
    '/build/assets/Avatar-v2.js',
    '/build/assets/TooltipProvider-v2.js',
    '/build/assets/Show-v2.js',
    '/build/assets/Icon-v2.js',
    '/build/assets/index-v22.js',
    '/build/assets/Button-v2.js',
    '/build/assets/Carousel.vue_vue_type_script_setup_true_lang-v2.js',
    '/build/assets/Primitive-v2.js',
    '/build/assets/Welcome-v2.js',
    '/build/assets/Create-v2.js',
    '/build/assets/AppLayout.vue_vue_type_script_setup_true_lang-v2.js',
    '/build/assets/app-v2.js',
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
