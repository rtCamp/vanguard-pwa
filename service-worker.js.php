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

	var offlineImage = '/wp-content/uploads/2018/10/image-not-found.png';
	var offlinePage = '/offline';

	workbox.precaching.precacheAndRoute([
	    offlineImage,
        offlinePage
    ]);

	var match = function ( obj ) {
		console.log(obj);
		if ( typeof obj !== 'object' || typeof obj.url !== 'object' || typeof obj.event !== 'object' ) {
			return false;
		}

		if ( typeof obj.url.pathname !== 'undefined' && ( obj.url.pathname.includes('/wp-admin/') || obj.url.pathname.includes('/wp-json/') ) ) {
			return false;
		}

		var hosts = [];
		hosts['vanguard2.c.rtdemo.in'] = 'vanguard2.c.rtdemo.in';
		hosts['vanguard1.blr.rtdemo.in'] = 'vanguard1.blr.rtdemo.in';
		//hosts['fonts.gstatic.com'] = 'fonts.gstatic.com';
		hosts['cdn.onesignal.com'] = 'cdn.onesignal.com';

		if ( typeof hosts[obj.url.host] !== 'undefined' ) {
            if ( obj.url.pathname.includes('/wp-includes/') && ( ! obj.url.pathname.includes( 'jquery' ) && ! obj.url.pathname.includes( 'dashicons.min.css' ) ) ) {
                return false;
            }

            return true;
		}

		//var extension = url.url.pathname.split( /\#|\?/ )[0].split( '/' ).pop().split( '.' ).pop();
		/*if ( ! [ 'png', 'jpg', 'jpeg' ].includes( extension ) ) {
			return true;
		}*/

		return false;
	};

	var handler = async function ( obj ) {

        var imagesCaching = workbox.strategies.networkFirst({
            cacheName: 'vanguard-networkfirst-images-v1',
            plugins: [
                new workbox.expiration.Plugin({
                    // Keep at most 50 entries.
                    maxEntries: 15,
                    // Don't keep any entries for more than 1 hour.
                    maxAgeSeconds: 60 * 60,
                    // Automatically cleanup if quota is exceeded.
                    purgeOnQuotaError: true
                })
            ]
        });

        var assetsCaching = workbox.strategies.networkFirst({
            cacheName: 'vanguard-networkfirst-assets-v1',
            plugins: [
                new workbox.expiration.Plugin({
                    // Keep at most 50 entries.
                    maxEntries: 15,
                    // Don't keep any entries for more than 1 hour.
                    maxAgeSeconds: 60 * 60,
                    // Automatically cleanup if quota is exceeded.
                    purgeOnQuotaError: true
                })
            ]
        });

        var docCaching = workbox.strategies.networkFirst({
            cacheName: 'vanguard-networkfirst-doc-v1',
            plugins: [
                new workbox.expiration.Plugin({
                    // Keep at most 50 entries.
                    maxEntries: 30,
                    // Don't keep any entries for more than 1 hour.
                    maxAgeSeconds: 60 * 60,
                    // Automatically cleanup if quota is exceeded.
                    purgeOnQuotaError: true
                })
            ]
        });

        var extension = obj.url.pathname.split( /\#|\?/ )[0].split( '/' ).pop().split( '.' ).pop();
        if ( [ 'png', 'jpg', 'jpeg', 'gif', 'svg' ].includes( extension ) ) {
            try {
                var resp = await imagesCaching.handle( obj );
                if ( ! resp ) { throw 'Empty response'; }
                return resp;
            } catch (err) {
                return caches.match( offlineImage );
            }
        } else if ( [ 'js', 'css', 'woff2', 'woff', 'json', 'ttf' ].includes( extension ) ) {
            return assetsCaching.handle( obj );
        }

        try {
            var resp = await docCaching.handle( obj );
            if ( ! resp ) { throw 'Empty response'; }
            return resp;
        } catch (err) {
            return caches.match( offlinePage );
        }

    };

	workbox.routing.registerRoute(
		match,
        handler
	);
} else {
	console.log(`Workbox didn't load 😬`);
}

self.addEventListener('install', event => {
	self.skipWaiting();
});
