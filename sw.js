self.addEventListener('install', function(e) {
  e.waitUntil(
    caches.open('peliohje-cache-v1').then(function(cache) {
        return cache.addAll([
  		'/',
		'main.js',
		'index.php',
  		'jquery-3.3.1.min.js',
  		'peliohje.css'
		]);
      })
  );
});


self.addEventListener('fetch', function(event) {
 console.log(event.request.url);

 event.respondWith(
   caches.match(event.request).then(function(response) {
     return response || fetch(event.request);
   })
 );
});

