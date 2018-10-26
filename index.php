<?php
/*
 * Plugin Name: vanguard-pwa
 * Description: Plugin to add PWA support in vanguard.
 */

add_action( 'wp_enqueue_scripts', function () {
	$worker_url = plugin_dir_url( __FILE__ ) . 'service-worker.js.php' ;
	wp_enqueue_script( 'vanguard-check-sw', plugin_dir_url( __FILE__ ) . '/vanguard-check-sw.js' );

	wp_localize_script( 'vanguard-check-sw', 'workerData', array( 'workerUrl' => $worker_url ) );
} );

add_action( 'wp_head', function () {
	if ( is_admin() ) {
		return;
	}
	return;

	$url = plugin_dir_url( __FILE__ ) . 'manifest.json';
	?>
	<link rel="manifest" href="<?php echo esc_url( $url ); ?>">
	<?php
} );
