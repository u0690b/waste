const staticCacheName = 'waste-static-v2';
const inertiaCacheName = 'waste-inertia-v2';
const assets = [
    '/',
    '/create',
    '/draft',
    '/offline',
    '/settings/appearance',
    '/api/common',
    '/build/manifest.json',
    '/build/logo1-v13.png',
    '/build/logo-v13.png',
    '/build/app-v13.css',
    '/build/app-v13.js',
];
const assetsInertia = ['/', '/create', '/draft', '/offline', '/settings/appearance'];
// install event
self.addEventListener('install', (event) => {
    event.waitUntil(
        Promise.all([
            caches.open(staticCacheName).then((cache) => {
                let cc = cache.addAll(assets);
                console.log('cheched');
                return cc;
            }),
            caches.open(inertiaCacheName).then(async (cache) => {
                // Pre-cache an Inertia route
                for (let index = 0; index < assetsInertia.length; index++) {
                    const element = assetsInertia[index];
                    const inertiaRequest = new Request(element, {
                        headers: {
                            'X-Inertia': 'true',
                            'X-Requested-With': 'XMLHttpRequest',
                            'x-inertia-version': 'd1decc9a4198b7bf31e6e352bdcc9b66',
                        },
                    });

                    const response = await fetch(inertiaRequest);
                    if (response.ok) {
                        await cache.put(inertiaRequest, response.clone());
                    }
                }

                return cache;
            }),
        ]),
    );
});

// Activate: cleanup old caches
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) =>
            Promise.all(
                cacheNames.map((cache) => {
                    if (cache !== staticCacheName && cache !== inertiaCacheName) return caches.delete(cache);
                    else return null;
                }),
            ),
        ),
    );
});
self.addEventListener('fetch', (event) => {
    const url = new URL(event.request.url);
    if (event.request.headers.get('X-Inertia') === 'true') {
        event.respondWith(cacheInertiaRequest(event.request));
    } else {
        // Only intercept your API calls
        if (!url.pathname.startsWith('/save_token')) {
            event.respondWith(handleApiRequest(event.request));
        }
    }
});

async function handleApiRequest(request) {
    const cache = await caches.open(staticCacheName);

    // Try to get from cache first
    const cachedResponse = await cache.match(request);

    // Fetch from network in background
    const fetchPromise = fetch(request)
        .then((networkResponse) => {
            // Save a copy to cache
            if (request.method == 'GET') cache.put(request, networkResponse.clone());
            return networkResponse;
        })
        .catch(() => {
            // Network failed, stay silent
            return cache.match('/offline');
        });

    // Return cached response immediately, update in background
    return cachedResponse || fetchPromise || caches.match('/offline');
}

async function cacheInertiaRequest(request) {
    const cache = await caches.open(inertiaCacheName);

    // Try cache first
    const cachedResponse = await cache.match(request);

    // Fetch fresh copy in background
    const networkPromise = fetch(request)
        .then((response) => {
            if (response.ok) {
                if (request.method == 'GET') cache.put(request, response.clone());
            }
            return response;
        })
        .catch(() => cachedResponse || cache.match('/offline')); // fallback when offline

    // Return cached version immediately, update later
    return cachedResponse || networkPromise;
}
// self.addEventListener('fetch', function (event) {
//     event.respondWith(
//         caches.open(staticCacheName).then(function (cache) {
//             return fetch(event.request)
//                 .then(function (response) {
//                     console.log('from network', event.request);
//                     cache.put(event.request, response.clone());
//                     return response;
//                 })
//                 .catch(function () {
//                     console.log('from cache', event.request);
//                     return caches.match(event.request).catch(function () {
//                         // If both fail, show a generic fallback:
//                         return caches.match('/offline');
//                         // However, in reality you'd have many different
//                         // fallbacks, depending on URL and headers.
//                         // Eg, a fallback silhouette image for avatars.
//                     });
//                 });
//         }),
//     );
// });
