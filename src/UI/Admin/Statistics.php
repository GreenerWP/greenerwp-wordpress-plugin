<?php
namespace GreenerWP\UI\Admin;

/**
 * Statistics page of GreenerWP.
 */
class Statistics {
  private $frontend = null;
  private $template_renderer = null;

	public function __construct( $frontend, $template_renderer ) {
    $this->frontend = $frontend;
    $this->template_renderer = $template_renderer;
	}

	public function run() {
		if ( ! get_option( 'greenerwp_statistics_enabled', false ) ) {
			return;
		}
		add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
  }

  public function add_admin_menu() {
    $page = add_submenu_page( 'greenerwp', __( 'Statistics', 'greenerwp' ), __( 'Statistics', 'greenerwp' ), 'manage_options', 'greenerwp_statistics', [ $this, 'render' ] );
  }

  public function render() {
    $this->template_renderer->render( 'admin/statistics', [] );
  }
}
