window.addEventListener( 'load', function () {
	console.log('load event');

	// Register custom service worker if onesignal sw doesn't exist.
	if ( 'serviceWorker' in navigator ) {
		navigator.serviceWorker.getRegistrations().then( function ( registrations ) {
			if ( !registrations.length ) {
				navigator.serviceWorker.register( workerData.workerUrl, { scope: '/' } );
			}
		} );
	}

	function checkNetworkStatus () {
		if ( typeof jQuery !== 'undefined' ) {
			if ( !navigator.onLine ) {
				var body = jQuery( 'body' );
				var elem = '<div style="width: 100% !important;background-color: #eeeeee;padding: 1em;text-align: center; font-weight: bold;position: fixed;z-index: 100;" id="vanguard-pwa-offline-notice">You\'re Offline.</div>';

				var first = body.children()[0];
				first = jQuery( first );
				body.prepend( elem );
				elem = jQuery( '#vanguard-pwa-offline-notice' );
				first.css( 'padding-top', elem.outerHeight() );
			} else {
				var elem = jQuery( '#vanguard-pwa-offline-notice' );
				elem.remove();

				var first = jQuery( 'body' ).children()[0];
				first = jQuery( first );
				first.css( 'padding-top', '0px' );
			}
		}
	}

	window.addEventListener( 'online', checkNetworkStatus );
	window.addEventListener( 'offline', checkNetworkStatus );

	checkNetworkStatus();
} );

window.addEventListener( 'beforeinstallprompt', function () {
	console.log( 'beforeinstallprompt' );
} );
