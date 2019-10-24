<?php
namespace LTWP\UI\Admin;

/**
 * Settings page of LTWP.
 */
class Settings {
  private $frontend = null;
  private $template_renderer = null;

	public function __construct( $frontend, $template_renderer ) {
    $this->frontend = $frontend;
    $this->template_renderer = $template_renderer;
	}

	public function run() {
		add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
    add_action( 'wp_footer', [ $this, 'add_caching_check_token' ] );
  }

  public function add_caching_check_token() {
    // TODO Only output when requested
    echo '<!-- lowtechwp caching check ' . microtime() . ' -->';
  }

  public function add_admin_menu() {
    $page = add_submenu_page(
			'lowtechwp', __( 'Settings', 'ltwp' ), __( 'Settings', 'ltwp' ),
			'manage_options', 'lowtechwp_settings', [ $this, 'render' ] );
		add_action('load-'.$page, [ $this, 'init_page' ] );
  }

  public function init_page() {
    /* add_thickbox(); */
  }

  public function render() {
    $this->template_renderer->render( 'admin/settings', [] );
  }
}
