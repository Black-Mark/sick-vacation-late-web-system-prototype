self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open('website-hr-cache').then((cache) => {
            return cache.addAll([
                '/',
                './index.php',
            ]);
        })
    );
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        })
    );
});