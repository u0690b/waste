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

