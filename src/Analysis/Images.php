<?php
namespace GreenerWP\Analysis;

/**
 * Checks for image optimizations.
 */
class Images {
	public function get_results() {
		global $cache_enabled;
		return [
			'greenerwp_jpeg_quality_reduced' => ( get_option( 'greenerwp_jpeg_quality', false ) ?: 82 ) < 82,
			'web_p_express_active' => !! defined( 'WEBPEXPRESS_PLUGIN' ),
		];
	}
}