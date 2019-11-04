<?php
namespace LTWP\UI\Admin;

/**
 * Implements the dashboard link in the plugins screen.
 */
class DashboardLink {
	public function __construct( string $basename ) {
		$this->basename = $basename;
	}

	public function run() {
		add_filter( 'plugin_action_links_' . $this->basename, [ $this, 'add_link' ] );
  }

	function add_link( $links ) {
		$links[] = '<a href="' .
							 admin_url( 'admin.php?page=lowtechwp' ) .
							 '">' . __( 'Dashboard' ) . '</a>';
		return $links;
	}
}
