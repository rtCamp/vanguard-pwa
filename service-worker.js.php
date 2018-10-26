<?php
if ( ! headers_sent() ) {
	header( "Service-Worker-Allowed: /" );
	header( "Content-Type: application/javascript" );
	header( "X-Robots-Tag: none" );
}
?>

importScripts('https://storage.googleapis.com/workbox-cdn/releases/3.6.1/workbox-sw.js');

if (workbox) {
	console.log(`Workbox is loaded 🎉`);

	var match = function (url, event) {
		console.log(url);
		if ( typeof url !== 'object' || typeof url.url !== 'object' || typeof url.event !== 'object' ) {
			return false;
		}

		if ( typeof url.url.pathname !== 'undefined' && url.url.pathname.includes('/wp-admin/') ) {
			return false;
		}

		var hosts = [];
		hosts['vanguard1.blr.rtdemo.in'] = 'vanguard1.blr.rtdemo.in';
		//hosts['fonts.gstatic.com'] = 'fonts.gstatic.com';
		hosts['cdn.onesignal.com'] = 'cdn.onesignal.com';

		if ( typeof hosts[url.url.host] !== 'undefined' ) {
			return true;
		}

		//var extension = url.url.pathname.split( /\#|\?/ )[0].split( '/' ).pop().split( '.' ).pop();
		/*if ( ! [ 'png', 'jpg', 'jpeg' ].includes( extension ) ) {
			return true;
		}*/

		return false;
	}

	workbox.routing.registerRoute(
		match,
		workbox.strategies.networkFirst({
			cacheName: 'vanguard-networkfirst-v2',
			plugins: [
				new workbox.expiration.Plugin({
					// Keep at most 50 entries.
					maxEntries: 50,
					// Don't keep any entries for more than 1 hour.
					maxAgeSeconds: 60 * 60,
					// Automatically cleanup if quota is exceeded.
					purgeOnQuotaError: true
				})
			]
		})
	);
} else {
	console.log(`Workbox didn't load 😬`);
}

self.addEventListener('install', event => {
	self.skipWaiting();
});
