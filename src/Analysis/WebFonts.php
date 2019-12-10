<?php
namespace GreenerWP\Analysis;

/**
 * Checks for web fonts.
 */
class WebFonts {
	public function get_results() {
		global $cache_enabled;
		return [
			'greenerwp_web_fonts_disable' => !! get_option( 'greenerwp_web_fonts_disable', false ),
		];
	}
}