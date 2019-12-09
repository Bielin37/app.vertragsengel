/*const cacheName = "cache-v1";
const precacheResources = [
  "index.php",
  "vertragsAuswahl.php",
  "vertragsUebersicht.php",
  "forms/logout.php",
  "forms/include/meta.php",
  "forms/include/logged.php",
  "forms/include/fragen.php",
  "css/main.css",
  "css/vertragsUebersicht.css",
  "css/vertragsAuswahl.css",
  "js/vertragsAuswahl.js",
  "js/vertragsUebersicht.js",
  "img/slider1_5.jpg",
  "img/slider2_5.jpg",
  "img/slider3_5.jpg",
  "img/slider4_5.jpg",
  "img/slider5_5.jpg",
  "forms/page-login.php",
  "db/sendRequest.php",
  "db/database.php"
];

self.addEventListener("install", event => {
  console.log("Service worker install event!");
  event.waitUntil(
    caches.open(cacheName).then(cache => {
      return cache.addAll(precacheResources);
    })
  );
});

self.addEventListener("activate", event => {
  console.log("Service worker activate event!");
});

self.addEventListener("fetch", event => {
  console.log("Fetch intercepted for:", event.request.url);
  event.respondWith(
    caches.match(event.request).then(cachedResponse => {
      if (cachedResponse) {
        return cachedResponse;
      }
      return fetch(event.request);
    })
  );
});*/
