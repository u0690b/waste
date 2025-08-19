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


const staticCacheName = 'site-static-v2';
const assets = [
    '/',
    '/create',
    '/draft',
    '/send',
    '/solved',
    '/settings/appearance',
    '/api/common',
    '/public/build/assets/Create-v2.js',
    '/public/build/assets/Dashboard-v2.js',
    '/public/build/assets/Draft-v2.js',
    '/public/build/assets/ForgotPassword-v2.js',
    '/public/build/assets/index-v2.js',
    '/public/build/assets/index-v22.js',
    '/public/build/assets/index-v23.js',
    '/public/build/assets/Label.vue_vue_type_script_setup_true_lang-v2.js',
    '/public/build/assets/Layout.vue_vue_type_script_setup_true_lang-v2.js',
    '/public/build/assets/loader-circle-v2.js',
    '/public/build/assets/Login-v2.js',
    '/public/build/assets/logo1-v2.png',
    '/public/build/assets/logo-v2.png',
    '/public/build/assets/Password-v2.js',
    '/public/build/assets/Profile-v2.js',
    '/public/build/assets/Register-v2.js',
    '/public/build/assets/ResetPassword-v2.js',
    '/public/build/assets/Send-v2.js',
    '/public/build/assets/Solved-v2.js',
    '/public/build/assets/store-v2.js',
    '/public/build/assets/TextLink.vue_vue_type_script_setup_true_lang-v2.js',
    '/public/build/assets/useForwardExpose-v2.js',
    '/public/build/assets/usePortal-v2.js',
    '/public/build/assets/VerifyEmail-v2.js',
    '/public/build/assets/Welcome-v2.js',
    '/public/build/assets/Appearance-v2.js',
    '/public/build/assets/AppLayout.vue_vue_type_script_setup_true_lang-v2.js',
    '/public/build/assets/app-v2.css',
    '/public/build/assets/app-v2.js',
    '/public/build/assets/AuthLayout.vue_vue_type_script_setup_true_lang-v2.js',
    '/public/build/assets/Avatar-v2.js',
    '/public/build/assets/Button-v2.js',
    '/public/build/assets/Card-v2.js',
    '/public/build/assets/ConfirmPassword-v2.js',
];

// install event
self.addEventListener('install', (evt) => {
    console.log('service worker installed');
    evt.waitUntil(
        caches.open(staticCacheName).then((cache) => {
            console.log('caching shell assets', cache);
            cache.addAll(assets);
        }),
    );
});

// activate event
self.addEventListener('activate', (evt) => {
    console.log('service worker activated', evt);
    evt.waitUntil(
        caches.keys().then((keys) => {
            //console.log(keys);
            return Promise.all(keys.filter((key) => key !== staticCacheName).map((key) => caches.delete(key)));
        }),
    );
});

self.addEventListener('fetch', (evt) => {
    if (assets.find((v) => evt.request.url.endsWith(v))) {
        console.log(evt.request.url);
        evt.respondWith(
            caches.match(evt.request).then((cacheRes) => {
                return cacheRes || fetch(evt.request);
            }),
        );
    }
});
