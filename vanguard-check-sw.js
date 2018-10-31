window.addEventListener( 'load', function () {

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
				var elem = '<div style="width: 100% !important;background-color: tomato;padding: 1em;color: white;text-align: center; font-weight: bold;" id="vanguard-pwa-offline-notice">You\'re Offline.</div>';

				body.prepend( elem );
			} else {
				var elem = jQuery( '#vanguard-pwa-offline-notice' );
				elem.remove();
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
