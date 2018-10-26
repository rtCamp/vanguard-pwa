<?php

function vanguard_mu_wp_get_attachment_url( $url ) {
//	error_log($url);
//	error_log(false === strpos( $url, 'vanguard1.blr.rtdemo.in' ));
	if ( false === strpos( $url, 'vanguard1.blr.rtdemo.in' ) ) {
//		error_log('nope');
		return $url;
	}

	$url = str_replace( 'vanguard1.blr.rtdemo.in', 'www.vanguardngr.com', $url );
//	error_log($url);

	return $url;
}

//add_filter( 'wp_get_attachment_url', 'vanguard_mu_wp_get_attachment_url' );

/*add_filter( 'wp_calculate_image_srcset', function ($srcset) {
	if ( empty( $srcset ) || ! is_array( $srcset ) ) {
		return $srcset;
	}

	$new_srcset = array();

	foreach ( $srcset as $key=>$img ) {
		if ( false !== strpos( $img['url'], 'vanguard1.blr.rtdemo.in' ) ) {
			$img['url'] = str_replace( 'vanguard1.blr.rtdemo.in', 'www.vanguardngr.com', $img['url'] );
			$new_srcset[$key] = $img;
		}
	}

	return $new_srcset;
} );*/
