<?php
namespace GreenerWP\Analysis\Plugins;

/**
 * Analysis for Contact Form 7.
 */
class WPCF7 {
	public function get_results() {
		return [
			'plugin_wpcf7_active' => defined( 'WPCF7_PLUGIN' ),
			'greenerwp_wpcf7_jquery_fix_enabled' => get_option( 'greenerwp_wpcf7_jquery_fix_enabled', false ),
		];
	}
}