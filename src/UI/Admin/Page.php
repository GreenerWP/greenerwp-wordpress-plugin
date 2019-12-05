<?php
namespace GreenerWP\UI\Admin;

/**
 * Main admin page of GreenerWP.
 */
class Page {
  private $frontend = null;
  private $template_renderer = null;

	public function __construct( $frontend, $template_renderer ) {
    $this->frontend = $frontend;
    $this->template_renderer = $template_renderer;
	}

	public function run() {
		add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
    $this->frontend->enqueue_admin_script(
      'greenerwp-ui-admin-page', 'ui/admin/page.js',
      [ 'wp-i18n', 'wp-api', 'wp-components', 'wp-element', 'wp-data', 'wp-redux-routine' ] );
    $this->frontend->enqueue_admin_style(
      'greenerwp-ui-admin', 'admin.css', [ 'wp-components' ] );
  }

  public function add_admin_menu() {
    add_menu_page( __( 'greenerWP', 'greenerwp' ), __( 'greenerWP', 'greenerwp' ), 'manage_options', 'greenerwp', [ $this, 'render' ] );
  }

  public function render() {
    $this->template_renderer->render( 'admin/page', [] );
  }
}
