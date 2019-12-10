<?php
namespace GreenerWP\UI\Frontend\Tweaks\Plugins;

/**
 * Prevents WPCF7's use of jQuery and Styles on every post/page.
 */
class WPCF7 {
	public function run() {
		if ( ! get_option( 'greenerwp_wpcf7_jquery_fix_enabled', false ) ) {
			return;
		}
    add_filter( 'wpcf7_load_js', '__return_false' );
    add_filter( 'wpcf7_load_css', '__return_false' );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	public function enqueue_scripts() {
		global $post;
		if( ! ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'contact-form-7' ) ) )  {
			return;
		}
		if ( function_exists( 'wpcf7_enqueue_styles' )
			&& function_exists( 'wpcf7_enqueue_scripts' ) ) {
			wpcf7_enqueue_styles();
			wpcf7_enqueue_scripts();
    }
	}
}