<?php
namespace GreenerWP\Analysis;

/**
 * Checks for disabled emojis.
 */
class Emojis {
	public function get_results() {
		global $cache_enabled;
		return [
			'disable_emojis_active' => function_exists( 'disable_emojis' ),
		];
	}
}