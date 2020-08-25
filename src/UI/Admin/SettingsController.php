<?php
namespace GreenerWP\UI\Admin;

/**
 * REST controller for handling settings.
 */
class SettingsController {
	public function __construct() {
		$this->namespace = '/greenerwp/v1';
	}

	public function run() {
		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	/**
	 * Remove any filters and actions.
	 */
	public function tear_down() {
		remove_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	/**
	 * Registers the REST route.
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace, '/settings', [
				[
					'methods'   => [ 'GET', 'POST' ],
					'callback'  => [ $this, 'handle_settings' ],
					'permission_callback' => function ( $request ) {
						return current_user_can( 'manage_options' );
					},
				],
			] );
	}

	/**
	 * Handles settings request.
	 *
	 * @param WP_REST_Request $request Current request.
	 */
	public function handle_settings( $request ) {
		$known_settings = [
			'statistics_enabled' => false,
			'image_previews_enabled' => false,
			'jpeg_quality' => '',
			'web_fonts_disable' => false,
			'wpcf7_jquery_fix_enabled' => false,
		];
		if ( $request->get_method() === 'POST' ) {
      $settings = (array) json_decode( $request->get_body() );
			foreach ( array_keys( $known_settings ) as $key ) {
				if ( array_key_exists( $key, $settings ) ) {
					update_option( 'greenerwp_' . $key, $settings[ $key ] );
				}
			}
			return;
    }
		$settings = [];
		foreach ( $known_settings as $key => $default ) {
			$settings[ $key ] = get_option( 'greenerwp_' . $key, $default );
		}
		return $settings;
	}
}