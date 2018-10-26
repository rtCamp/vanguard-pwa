// Register custom service worker if onesignal sw doesn't exist.
if ( 'serviceWorker' in navigator ) {
	window.addEventListener( 'load', function () {
		navigator.serviceWorker.getRegistrations().then( function ( registrations ) {
			if ( ! registrations.length ) {
				navigator.serviceWorker.register( workerData.workerUrl, { scope: '/' } );
			}
		} )
	} )
}

window.addEventListener( 'beforeinstallprompt', function () {
	console.log('beforeinstallprompt');
} );
