<?php
namespace LTWP\UI\Admin;

/**
 * Recipes page of LTWP.
 */
class Recipes {
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
    add_submenu_page( 'lowtechwp', __( 'Recipes', 'ltwp' ), __( 'Recipes', 'ltwp' ), 'manage_options', 'lowtechwp_recipes', [ $this, 'render' ] );
  }

  public function render() {
    $this->template_renderer->render( 'admin/recipes', [] );
  }
}
