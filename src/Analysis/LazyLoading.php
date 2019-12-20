<?php
namespace GreenerWP\Analysis;

/**
 * Checks for lazy loading.
 */
class LazyLoading {
	public function get_results() {
		return [
			'greenerwp_image_lazy_loading' =>
				( !! get_option( 'greenerwp_image_previews_lazy_loading', false ) &&
					!! get_option( 'greenerwp_image_previews_enabled', false ) ),
		];
	}
}