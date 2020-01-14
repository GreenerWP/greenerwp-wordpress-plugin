<?php
namespace GreenerWP\UI;

/**
 * Manages frontend scripts and styles.
 */
class Frontend {
  private $settings = null;
  private $scripts = [];
  private $admin_scripts = [];
  private $styles = [];
  private $admin_styles = [];

	public function __construct( $settings ) {
    $this->settings = $settings;
	}

  public function enqueue_script( $handle, $path, $deps ) {
    $this->scripts[$handle] = [
      'path' => $path,
      'deps' => $deps,
    ];
  }

  public function localize_script( $handle, $var, $args ) {
    $this->localizations[$handle][$var] = $args;
  }

  public function enqueue_admin_script( $handle, $path, $deps ) {
    $this->admin_scripts[$handle] = [
      'path' => $path,
      'deps' => $deps,
    ];
  }

  public function enqueue_style( $handle, $path ) {
    $this->styles[$handle] = [
      'path' => $path,
    ];
  }

  public function enqueue_admin_style( $handle, $path, $deps ) {
    $this->admin_styles[$handle] = [
      'path' => $path,
      'deps' => $deps,
    ];
  }

  public function run() {
		add_action( 'wp_enqueue_scripts', [ $this, 'on_enqueue_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'on_enqueue_admin_scripts' ] );
		add_action( 'wp', [ $this, 'enqueue_core' ] );
	}

	public function enqueue_core() {
		$this->enqueue_style( 'greenerwp-frontend', 'frontend.css' );
    $this->enqueue_script(
      'greenerwp-frontend', 'frontend.js',
      [ ] );

		global $wp_query;
		$this->localize_script( 'greenerwp-frontend', 'greenerwpVars', [
			'root'  => esc_url_raw( rest_url() ),
			'nonce' => wp_create_nonce( 'wp_rest' ),
			'postID' => get_queried_object_id(),
			'statisticsEnabled' => get_option( 'greenerwp_statistics_enabled', false ),
		] );
	}

	public function on_enqueue_scripts() {
    $this->enqueue_scripts();
  }

  public function on_enqueue_admin_scripts() {
    $this->enqueue_scripts( true );
  }

  private function enqueue_scripts( $admin_scripts = false ) {
    $scripts = $admin_scripts ? $this->admin_scripts : $this->scripts;
    foreach ( $scripts as $handle => $args ) {
      $script_url = $this->settings['js_base_url'] . '/' . $args['path'];
      $script_path = $this->settings['js_base_path'] . '/' . $args['path'];
      wp_enqueue_script(
        $handle, $script_url,
        $args['deps'], filemtime( $script_path ), true );
    }

    $localizations = $this->localizations ?? [];
    foreach ( $localizations as $handle => $vars ) {
			foreach ( $vars as $var => $args ) {
				wp_localize_script( $handle, $var, $args );
			}
		}

    $styles = $admin_scripts ? $this->admin_styles : $this->styles;
    foreach ( $styles as $handle => $args ) {
      $style_url = $this->settings['css_base_url'] . '/' . $args['path'];
      $style_path = $this->settings['css_base_path'] . '/' . $args['path'];
      wp_enqueue_style(
        $handle, $style_url,
        $args['deps'] ?? [], filemtime( $style_path ) );
    }
  }
}
