<?php
namespace GreenerWP\UI\Frontend\Tweaks;

/**
 * REST controller for providing webside status.
 */
class DisableWebFonts {
	public function run() {
		if ( get_option( 'greenerwp_web_fonts_disable', false ) ) {
			add_action( 'wp_head', [ $this, 'add_styles' ], 9999 );
		}
	}

	/**
	 * Add styles to disable web fonts.
	 */
	public function add_styles() {
		?>
	<style>
		*:not(.ab-icon) {
			font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Helvetica Neue", Arial, sans-serif !important;
		}
	</style>
		<?php
	}
}