<?php
namespace GreenerWP\Analysis;

/**
 * Checks for active site caching.
 */
class Caching {
	public function get_results() {
		global $cache_enabled;
		return [
			'wp_super_cache_active' => defined( 'WPCACHEHOME' ),
			'wp_super_cache_configured' => $cache_enabled,
		];
	}
}