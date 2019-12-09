<?php
namespace GreenerWP\UI\Frontend\Tweaks;

/**
 * Overwrites default JPEG quality setting.
 */
class JPEGQuality {
	public function run() {
		$jpeg_quality = get_option( 'greenerwp_jpeg_quality', '' );
		if ( $jpeg_quality ) {
			add_filter( 'jpeg_quality', function( $arg ) use ( $jpeg_quality ) {
				return $jpeg_quality;
			} );
		}
	}
}