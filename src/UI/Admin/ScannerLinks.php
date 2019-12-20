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
			'title' => __( 'greenerWP', 'greenerwp' ),
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
