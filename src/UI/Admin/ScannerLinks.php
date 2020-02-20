<?php
namespace GreenerWP\UI\Admin;

/**
 * Adds link to page scanner in various places.
 */
class ScannerLinks {
	public function __construct() {
	}

	public function run() {
		add_action( 'admin_bar_menu', [ $this, 'add_admin_bar_menu_links' ], 100 );
  }

	/**
	 * Adds link to the admin bar.
	 */
	function add_admin_bar_menu_links( $wp_admin_bar ) {
		if ( is_admin() ) {
			return;
		}

		$scheme = is_ssl() ? 'https://' : 'http://';
		$url = "{$scheme}{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

		$wp_admin_bar->add_node( [
			'id' => 'greenerwp',
			'title' => '<span class="ab-icon" style="display:inline-block; width:0.7em; height:0.5em; top:0.4em; background: url(\'' . Page::MENU_ICON . '\') no-repeat !important"><span class="screen-reader-text">' . __( 'GreenerWP', 'greenerwp' ) . '</span></span>',
			'meta' => [
				'title' => __( 'GreenerWP Tools', 'greenerwp' ),
			],
		] );

		$wp_admin_bar->add_node( [
			'id' => 'greenerwp_scanner_link',
			'parent' => 'greenerwp',
			'title' => __( 'Scan page', 'greenerwp' ),
			'href' => 'https://scan.greenerwp.net/?url=' . urlencode( $url ),
			'meta' => [
				'target' => '_blank',
			],
		] );
	}
}
