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

	window.addEventListener( 'beforeinstallprompt', function () {
		console.log( 'beforeinstallprompt' );
	} );
} );

function checkNetworkStatus () {
	console.log( navigator.onLine ? 'online' : 'offline' );
}

window.addEventListener( 'online', checkNetworkStatus );
window.addEventListener( 'offline', checkNetworkStatus );