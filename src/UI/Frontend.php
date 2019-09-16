<?php
namespace LTWP\UI;

/**
 * Manages frontend scripts and styles.
 */
class Frontend {
  private $settings = null;
  private $scripts = [];
  private $admin_scripts = [];

	public function __construct( $settings ) {
    $this->settings = $settings;
	}

  public function enqueue_script( $handle, $path, $deps ) {
    $this->scripts[$handle] = [
      'path' => $path,
      'deps' => $deps,
    ];
  }

  public function enqueue_admin_script( $handle, $path, $deps ) {
    $this->admin_scripts[$handle] = [
      'path' => $path,
      'deps' => $deps,
    ];
  }

  public function run() {
		add_action( 'wp_enqueue_scripts', [ $this, 'on_enqueue_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'on_enqueue_admin_scripts' ] );
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
  }
}
